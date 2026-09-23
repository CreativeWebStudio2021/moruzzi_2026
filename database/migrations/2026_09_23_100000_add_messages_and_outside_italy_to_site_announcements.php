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
            if (! Schema::hasColumn('site_announcements', 'messages')) {
                $table->json('messages')->nullable()->after('message');
            }
            if (! Schema::hasColumn('site_announcements', 'outside_italy_only')) {
                $table->boolean('outside_italy_only')->default(false)->after('enabled');
            }
        });

        $rows = DB::table('site_announcements')->select('id', 'message', 'messages')->get();
        foreach ($rows as $row) {
            $existing = [];
            if (! empty($row->messages)) {
                $decoded = is_string($row->messages)
                    ? json_decode($row->messages, true)
                    : $row->messages;
                if (is_array($decoded)) {
                    $existing = $decoded;
                }
            }

            $it = trim((string) ($existing['it'] ?? $row->message ?? ''));
            if ($it !== '') {
                $existing['it'] = $it;
            }

            DB::table('site_announcements')->where('id', $row->id)->update([
                'messages' => $existing !== [] ? json_encode($existing, JSON_UNESCAPED_UNICODE) : null,
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('site_announcements', function (Blueprint $table) {
            if (Schema::hasColumn('site_announcements', 'outside_italy_only')) {
                $table->dropColumn('outside_italy_only');
            }
            if (Schema::hasColumn('site_announcements', 'messages')) {
                $table->dropColumn('messages');
            }
        });
    }
};
