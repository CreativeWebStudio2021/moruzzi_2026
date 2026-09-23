<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_announcements', function (Blueprint $table) {
            if (! Schema::hasColumn('site_announcements', 'reopen_labels')) {
                $table->json('reopen_labels')->nullable()->after('reopen_label');
            }
        });

        $rows = DB::table('site_announcements')->select('id', 'reopen_label', 'reopen_labels')->get();
        foreach ($rows as $row) {
            $existing = [];
            if (! empty($row->reopen_labels)) {
                $decoded = is_string($row->reopen_labels)
                    ? json_decode($row->reopen_labels, true)
                    : $row->reopen_labels;
                if (is_array($decoded)) {
                    $existing = $decoded;
                }
            }

            $it = trim((string) ($existing['it'] ?? $row->reopen_label ?? ''));
            if ($it !== '') {
                $existing['it'] = $it;
            }

            DB::table('site_announcements')->where('id', $row->id)->update([
                'reopen_labels' => $existing !== [] ? json_encode($existing, JSON_UNESCAPED_UNICODE) : null,
            ]);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('site_announcements', 'reopen_labels')) {
            Schema::table('site_announcements', function (Blueprint $table) {
                $table->dropColumn('reopen_labels');
            });
        }
    }
};
