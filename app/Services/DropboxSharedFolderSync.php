<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;

class DropboxSharedFolderSync
{
    private const LIST_FOLDER_URL = 'https://api.dropboxapi.com/2/files/list_folder';

    private const LIST_FOLDER_CONTINUE_URL = 'https://api.dropboxapi.com/2/files/list_folder/continue';

    private const DOWNLOAD_URL = 'https://content.dropboxapi.com/2/sharing/get_shared_link_file';

    /** @var array<string, int> */
    private array $localIndex = [];

    /** @var array<string, int> basename lowercase => size su R2 */
    private array $r2ImageIndex = [];

    public function __construct(
        private readonly ?string $sharedLinkUrl,
        private readonly ?string $accessToken,
        private readonly string $targetPath,
        /** @var list<string> */
        private readonly array $allowedExtensions,
        private readonly bool $preservePaths,
        private readonly string $stateFile,
        private readonly ?string $imagesSubdirectory = null,
        private readonly ?CertificateImageR2Service $certificateImages = null,
    ) {}

    /**
     * @return array{listed: int, missing: int, downloaded: int, skipped: int, errors: list<string>}
     */
    public function sync(bool $dryRun = false): array
    {
        $this->assertConfigured();

        if (! $dryRun) {
            $this->ensureTargetDirectory();
        }

        $this->localIndex = $this->buildLocalIndex();
        $this->r2ImageIndex = $this->certificateImages?->isConfigured()
            ? $this->certificateImages->buildSizeIndex()
            : [];

        $stats = [
            'listed' => 0,
            'missing' => 0,
            'downloaded' => 0,
            'skipped' => 0,
            'errors' => [],
        ];

        foreach ($this->listRemoteFiles() as $entry) {
            $stats['listed']++;

            if (($entry['.tag'] ?? '') !== 'file') {
                continue;
            }

            if (! $this->isAllowedFile($entry['name'] ?? '')) {
                $stats['skipped']++;

                continue;
            }

            $dropboxPath = ltrim(str_replace('\\', '/', $entry['path_display'] ?? $entry['path_lower'] ?? $entry['name'] ?? ''), '/');
            $relativePath = $this->relativePath($dropboxPath);
            $extension = strtolower(pathinfo((string) ($entry['name'] ?? ''), PATHINFO_EXTENSION));
            $isPsd = $extension === 'psd';
            $isImage = $isPsd || $this->isImageFile((string) ($entry['name'] ?? ''));
            $localPath = $isPsd
                ? $this->localPathForConvertedImage($relativePath, 'jpg')
                : $this->localPath($relativePath);
            $remoteSize = (int) ($entry['size'] ?? 0);
            $outputName = basename($localPath);

            if ($isImage) {
                if ($this->imageAlreadyOnR2($outputName, $isPsd, $remoteSize)) {
                    $stats['skipped']++;

                    continue;
                }

                // Reliquia locale da upload R2 fallito: riprova solo l'upload.
                if (! $dryRun && is_file($localPath) && ($isPsd || $this->fileAlreadyPresent($localPath, $remoteSize))) {
                    $stats['missing']++;
                    try {
                        $uploadedSize = (int) filesize($localPath);
                        $this->uploadImageToR2AndCleanup($localPath, $outputName);
                        $stats['downloaded']++;
                        $this->r2ImageIndex[strtolower($outputName)] = $uploadedSize;
                    } catch (\Throwable $e) {
                        $message = "{$relativePath}: {$e->getMessage()}";
                        $stats['errors'][] = $message;
                        Log::warning('Dropbox sync R2 upload failed', [
                            'path' => $relativePath,
                            'error' => $e->getMessage(),
                        ]);
                    }

                    continue;
                }
            } elseif ($this->fileAlreadyPresent($localPath, $remoteSize)) {
                $stats['skipped']++;

                continue;
            }

            $stats['missing']++;

            if ($dryRun) {
                continue;
            }

            try {
                if ($isImage) {
                    if ($isPsd) {
                        $this->downloadAndConvertPsdToJpeg($dropboxPath, $localPath);
                    } else {
                        $this->downloadFile($dropboxPath, $localPath);
                    }
                    $uploadedSize = is_file($localPath) ? (int) filesize($localPath) : $remoteSize;
                    $this->uploadImageToR2AndCleanup($localPath, $outputName);
                    $this->r2ImageIndex[strtolower($outputName)] = $uploadedSize;
                } else {
                    $this->downloadFile($dropboxPath, $localPath);
                    $this->localIndex[strtolower(basename($localPath))] = $remoteSize;
                }
                $stats['downloaded']++;
            } catch (\Throwable $e) {
                $message = "{$relativePath}: {$e->getMessage()}";
                $stats['errors'][] = $message;
                Log::warning('Dropbox sync download failed', [
                    'path' => $relativePath,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        if (! $dryRun) {
            $this->writeState($stats);
        }

        return $stats;
    }

    private function imageAlreadyOnR2(string $filename, bool $isPsd, int $remoteSize): bool
    {
        $key = strtolower(basename($filename));

        if (! array_key_exists($key, $this->r2ImageIndex)) {
            return false;
        }

        // JPG convertiti da PSD: basta presenza su R2 (size diversa dal PSD remoto).
        if ($isPsd) {
            return true;
        }

        if ($remoteSize <= 0) {
            return true;
        }

        return $this->r2ImageIndex[$key] === $remoteSize;
    }

    private function uploadImageToR2AndCleanup(string $localPath, string $filename): void
    {
        if ($this->certificateImages === null || ! $this->certificateImages->isConfigured()) {
            throw new RuntimeException('R2 non configurato: impossibile caricare le immagini certificate senza accumulo locale.');
        }

        $this->certificateImages->upload($localPath, $filename);

        if (is_file($localPath) && ! @unlink($localPath)) {
            Log::warning('Dropbox sync: upload R2 ok ma impossibile eliminare copia locale', [
                'path' => $localPath,
            ]);
        }
    }

    private function assertConfigured(): void
    {
        if ($this->sharedLinkUrl === null || $this->sharedLinkUrl === '') {
            throw new RuntimeException('DROPBOX_SHARED_LINK_URL non configurato.');
        }

        if ($this->accessToken === null || $this->accessToken === '') {
            throw new RuntimeException('DROPBOX_ACCESS_TOKEN non configurato.');
        }
    }

    /**
     * @return \Generator<int, array<string, mixed>>
     */
    private function listRemoteFiles(): \Generator
    {
        yield from $this->listFolderContents('');
    }

    /**
     * @return \Generator<int, array<string, mixed>>
     */
    private function listFolderContents(string $path): \Generator
    {
        $payload = [
            'path' => $path,
            'recursive' => false,
            'include_media_info' => false,
            'include_deleted' => false,
            'shared_link' => [
                'url' => $this->sharedLinkUrl,
            ],
        ];

        $response = $this->apiPost(self::LIST_FOLDER_URL, $payload);

        yield from $this->yieldEntriesWithSubfolders($response['entries'] ?? []);

        $cursor = ($response['has_more'] ?? false) ? ($response['cursor'] ?? null) : null;

        while ($cursor !== null) {
            $response = $this->apiPost(self::LIST_FOLDER_CONTINUE_URL, ['cursor' => $cursor]);

            yield from $this->yieldEntriesWithSubfolders($response['entries'] ?? []);

            $cursor = ($response['has_more'] ?? false) ? ($response['cursor'] ?? null) : null;
        }
    }

    /**
     * @param list<array<string, mixed>> $entries
     * @return \Generator<int, array<string, mixed>>
     */
    private function yieldEntriesWithSubfolders(array $entries): \Generator
    {
        foreach ($entries as $entry) {
            yield $entry;

            if (($entry['.tag'] ?? '') === 'folder') {
                $folderPath = $entry['path_display'] ?? $entry['path_lower'] ?? '';

                if ($folderPath !== '') {
                    yield from $this->listFolderContents($folderPath);
                }
            }
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function apiPost(string $url, array $payload): array
    {
        try {
            $response = Http::withToken($this->accessToken)
                ->timeout(120)
                ->acceptJson()
                ->post($url, $payload)
                ->throw();
        } catch (RequestException $e) {
            $body = $e->response?->json();
            $summary = is_array($body) ? ($body['error_summary'] ?? json_encode($body)) : $e->getMessage();

            throw new RuntimeException("Dropbox API error: {$summary}", 0, $e);
        }

        return $response->json() ?? [];
    }

    private function downloadFile(string $dropboxPath, string $localPath): void
    {
        $this->prepareLocalFile($localPath);
        $written = file_put_contents($localPath, $this->downloadFileContent($dropboxPath));

        if ($written === false) {
            throw new RuntimeException('Impossibile scrivere il file locale.');
        }
    }

    private function downloadAndConvertPsdToJpeg(string $dropboxPath, string $jpegPath): void
    {
        $this->prepareLocalFile($jpegPath);

        $tmpPsd = '/tmp/dropbox_psd_'.Str::uuid().'.psd';
        $tmpJpg = '/tmp/dropbox_psd_'.Str::uuid().'.jpg';

        try {
            $written = file_put_contents($tmpPsd, $this->downloadFileContent($dropboxPath));
            if ($written === false) {
                throw new RuntimeException('Impossibile scrivere il PSD temporaneo.');
            }

            $command = sprintf(
                'convert %s -auto-orient -colorspace sRGB -quality 92 %s 2>&1',
                escapeshellarg($tmpPsd.'[0]'),
                escapeshellarg($tmpJpg)
            );

            exec($command, $output, $exitCode);

            if ($exitCode !== 0 || ! is_file($tmpJpg)) {
                throw new RuntimeException('Conversione PSD→JPG fallita: '.implode(' ', $output));
            }

            if (! @rename($tmpJpg, $jpegPath)) {
                $moved = @copy($tmpJpg, $jpegPath);
                if (! $moved) {
                    throw new RuntimeException('Impossibile salvare il JPG convertito.');
                }
            }
        } finally {
            if (is_file($tmpPsd)) {
                @unlink($tmpPsd);
            }
            if (is_file($tmpJpg)) {
                @unlink($tmpJpg);
            }
        }
    }

    private function downloadFileContent(string $dropboxPath): string
    {
        $apiArg = json_encode([
            'url' => $this->sharedLinkUrl,
            'path' => $this->sharedLinkDownloadPath($dropboxPath),
        ], JSON_UNESCAPED_SLASHES);

        $response = Http::withToken($this->accessToken)
            ->withHeaders(['Dropbox-API-Arg' => $apiArg])
            ->timeout(300)
            ->send('POST', self::DOWNLOAD_URL, [
                'body' => '',
            ]);

        if (! $response->successful()) {
            $summary = $response->json('error_summary') ?? $response->body();

            throw new RuntimeException((string) $summary);
        }

        return (string) $response->body();
    }

    private function ensureTargetDirectory(): void
    {
        if (! is_dir($this->targetPath)) {
            if (! mkdir($this->targetPath, 02775, true) && ! is_dir($this->targetPath)) {
                throw new RuntimeException("Impossibile creare la directory: {$this->targetPath}");
            }
        }

        if (! is_writable($this->targetPath)) {
            throw new RuntimeException(
                "La directory {$this->targetPath} non è scrivibile dal processo web (www-data). "
                .'Esegui: chown admin:www-data public/h && chmod 2775 public/h'
            );
        }

        if ($this->imagesSubdirectory) {
            $imagesPath = rtrim($this->targetPath, '/').'/'.$this->imagesSubdirectory;

            if (! is_dir($imagesPath)) {
                if (! mkdir($imagesPath, 02775, true) && ! is_dir($imagesPath)) {
                    throw new RuntimeException("Impossibile creare la directory: {$imagesPath}");
                }
            }
        }
    }

    private function prepareLocalFile(string $localPath): void
    {
        $directory = dirname($localPath);

        if (! is_dir($directory)) {
            if (! mkdir($directory, 02775, true) && ! is_dir($directory)) {
                throw new RuntimeException("Impossibile creare la directory: {$directory}");
            }
        }

        if (! is_writable($directory)) {
            throw new RuntimeException("Directory non scrivibile: {$directory}");
        }

        // File esistenti creati come admin:admin (644) non sono sovrascrivibili:
        // vanno rimossi prima (basta permesso di scrittura sulla cartella).
        if (is_file($localPath) && ! is_writable($localPath) && ! unlink($localPath)) {
            throw new RuntimeException("Impossibile sostituire il file esistente: {$localPath}");
        }
    }

    /**
     * @return array<string, int>
     */
    private function buildLocalIndex(): array
    {
        if (! is_dir($this->targetPath)) {
            return [];
        }

        $index = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->targetPath, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if (! $file->isFile()) {
                continue;
            }

            $index[strtolower($file->getFilename())] = $file->getSize();
        }

        return $index;
    }

    private function fileAlreadyPresent(string $localPath, int $remoteSize): bool
    {
        if (! is_file($localPath)) {
            return false;
        }

        if ($remoteSize <= 0) {
            return true;
        }

        return filesize($localPath) === $remoteSize;
    }

    private function isAllowedFile(string $filename): bool
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        return in_array($extension, $this->allowedExtensions, true);
    }

    /**
     * Path per sharing/get_shared_link_file.
     * Con preserve_paths=false i file in sottocartelle (es. CERTIFICATI MORUZZI/)
     * vanno richiesti per basename: il path completo restituisce shared_link_access_denied.
     */
    private function sharedLinkDownloadPath(string $dropboxPath): string
    {
        $normalized = '/'.ltrim(str_replace('\\', '/', $dropboxPath), '/');

        if ($this->preservePaths) {
            return $normalized;
        }

        return '/'.basename($normalized);
    }

    private function relativePath(string $dropboxPath): string
    {
        $normalized = ltrim(str_replace('\\', '/', $dropboxPath), '/');

        if ($this->preservePaths) {
            return $normalized;
        }

        return basename($normalized);
    }

    private function localPath(string $relativePath): string
    {
        if ($this->preservePaths) {
            return rtrim($this->targetPath, '/').'/'.ltrim($relativePath, '/');
        }

        $filename = basename($relativePath);

        if ($this->imagesSubdirectory && $this->isImageFile($filename)) {
            return rtrim($this->targetPath, '/').'/'.$this->imagesSubdirectory.'/'.$filename;
        }

        return rtrim($this->targetPath, '/').'/'.$filename;
    }

    private function localPathForConvertedImage(string $relativePath, string $targetExtension): string
    {
        $filename = pathinfo(basename($relativePath), PATHINFO_FILENAME).'.'.$targetExtension;

        if ($this->imagesSubdirectory) {
            return rtrim($this->targetPath, '/').'/'.$this->imagesSubdirectory.'/'.$filename;
        }

        return rtrim($this->targetPath, '/').'/'.$filename;
    }

    private function isImageFile(string $filename): bool
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'ico'], true);
    }

    /**
     * @param array{listed: int, missing: int, downloaded: int, skipped: int, errors: list<string>} $stats
     */
    private function writeState(array $stats): void
    {
        $state = [
            'last_sync_at' => now()->toIso8601String(),
            'listed' => $stats['listed'],
            'missing' => $stats['missing'],
            'downloaded' => $stats['downloaded'],
            'skipped' => $stats['skipped'],
            'errors' => count($stats['errors']),
        ];

        file_put_contents($this->stateFile, json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}
