<?php

namespace App\Services;

use RuntimeException;

class DropboxHSyncRunner
{
    /**
     * @return array{listed: int, missing: int, downloaded: int, skipped: int, errors: list<string>}
     */
    public function run(bool $dryRun = false): array
    {
        $tokenManager = new DropboxTokenManager(
            appKey: config('dropbox_sync.app_key'),
            appSecret: config('dropbox_sync.app_secret'),
            accessToken: config('dropbox_sync.access_token'),
            refreshToken: config('dropbox_sync.refresh_token'),
            tokenCacheFile: config('dropbox_sync.token_cache_file'),
        );

        $sync = new DropboxSharedFolderSync(
            sharedLinkUrl: config('dropbox_sync.shared_link_url'),
            accessToken: $tokenManager->accessToken(),
            targetPath: config('dropbox_sync.target_path'),
            allowedExtensions: config('dropbox_sync.allowed_extensions', ['html', 'jpg']),
            preservePaths: (bool) config('dropbox_sync.preserve_paths', false),
            stateFile: config('dropbox_sync.state_file'),
            imagesSubdirectory: config('dropbox_sync.images_subdirectory'),
        );

        return $sync->sync($dryRun);
    }

    public function assertWebhookSecret(?string $provided): void
    {
        $expected = config('dropbox_sync.webhook_secret');

        if ($expected === null || $expected === '') {
            throw new RuntimeException('DROPBOX_SYNC_WEBHOOK_SECRET non configurato.');
        }

        if ($provided === null || ! hash_equals($expected, $provided)) {
            throw new RuntimeException('Token non valido.', 403);
        }
    }
}
