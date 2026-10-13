<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('product_certificates') || ! Schema::hasColumn('product_certificates', 'notarization_notes')) {
            return;
        }

        $table = DB::getTablePrefix().'product_certificates';
        DB::statement("ALTER TABLE `{$table}` MODIFY `notarization_notes` TEXT NULL");
    }

    public function down(): void
    {
        if (! Schema::hasTable('product_certificates') || ! Schema::hasColumn('product_certificates', 'notarization_notes')) {
            return;
        }

        $table = DB::getTablePrefix().'product_certificates';
        DB::statement("ALTER TABLE `{$table}` MODIFY `notarization_notes` VARCHAR(500) NULL");
    }
};

