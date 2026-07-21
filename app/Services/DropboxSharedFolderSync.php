<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class DropboxSharedFolderSync
{
    private const LIST_FOLDER_URL = 'https://api.dropboxapi.com/2/files/list_folder';

    private const LIST_FOLDER_CONTINUE_URL = 'https://api.dropboxapi.com/2/files/list_folder/continue';

    private const DOWNLOAD_URL = 'https://content.dropboxapi.com/2/sharing/get_shared_link_file';

    /** @var array<string, int> */
    private array $localIndex = [];

    public function __construct(
        private readonly ?string $sharedLinkUrl,
        private readonly ?string $accessToken,
        private readonly string $targetPath,
        /** @var list<string> */
        private readonly array $allowedExtensions,
        private readonly bool $preservePaths,
        private readonly string $stateFile,
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
            $localPath = $this->localPath($relativePath);
            $remoteSize = (int) ($entry['size'] ?? 0);

            if ($this->fileAlreadyPresent($localPath, $remoteSize)) {
                $stats['skipped']++;

                continue;
            }

            $stats['missing']++;

            if ($dryRun) {
                continue;
            }

            try {
                $this->downloadFile($dropboxPath, $localPath);
                $stats['downloaded']++;
                $this->localIndex[strtolower(basename($localPath))] = $remoteSize;
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

        $written = file_put_contents($localPath, $response->body());

        if ($written === false) {
            throw new RuntimeException('Impossibile scrivere il file locale.');
        }
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

        return rtrim($this->targetPath, '/').'/'.basename($relativePath);
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
