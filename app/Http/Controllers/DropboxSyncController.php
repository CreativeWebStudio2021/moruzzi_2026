<?php

namespace App\Http\Controllers;

use App\Services\DropboxHSyncRunner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use RuntimeException;

class DropboxSyncController extends Controller
{
    public function __invoke(Request $request, DropboxHSyncRunner $runner): JsonResponse|Response
    {
        set_time_limit(0);

        try {
            $runner->assertWebhookSecret($request->query('token'));
            $stats = $runner->run($request->boolean('dry_run'));
        } catch (RuntimeException $e) {
            return $this->respond($request, [
                'ok' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() === 403 ? 403 : 500);
        }

        $ok = $stats['errors'] === [];

        return $this->respond($request, [
            'ok' => $ok,
            'dry_run' => $request->boolean('dry_run'),
            'listed' => $stats['listed'],
            'missing' => $stats['missing'],
            'downloaded' => $stats['downloaded'],
            'skipped' => $stats['skipped'],
            'errors' => $stats['errors'],
            'executed_at' => now()->timezone(config('app.timezone'))->format('d/m/Y H:i:s'),
        ], $ok ? 200 : 500);
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function respond(Request $request, array $payload, int $status): JsonResponse|Response
    {
        if ($request->query('format') === 'json' || $request->wantsJson()) {
            return response()->json($payload, $status);
        }

        return response()->view('internal.dropbox-sync-result', [
            'ok' => (bool) ($payload['ok'] ?? false),
            'dryRun' => (bool) ($payload['dry_run'] ?? false),
            'listed' => (int) ($payload['listed'] ?? 0),
            'missing' => (int) ($payload['missing'] ?? 0),
            'downloaded' => (int) ($payload['downloaded'] ?? 0),
            'skipped' => (int) ($payload['skipped'] ?? 0),
            'errors' => $payload['errors'] ?? [],
            'message' => $payload['message'] ?? null,
            'executedAt' => $payload['executed_at'] ?? now()->timezone(config('app.timezone'))->format('d/m/Y H:i:s'),
        ], $status);
    }
}
