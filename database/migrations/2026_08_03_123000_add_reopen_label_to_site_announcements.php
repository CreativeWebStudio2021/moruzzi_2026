<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('site_announcements', 'reopen_label')) {
            Schema::table('site_announcements', function (Blueprint $table) {
                $table->string('reopen_label', 120)->nullable()->after('message');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('site_announcements', 'reopen_label')) {
            Schema::table('site_announcements', function (Blueprint $table) {
                $table->dropColumn('reopen_label');
            });
        }
    }
};
