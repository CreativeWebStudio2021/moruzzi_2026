<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('product_certificates') || ! Schema::hasColumn('product_certificates', 'product_name')) {
            return;
        }

        $table = DB::getTablePrefix().'product_certificates';
        DB::statement("ALTER TABLE `{$table}` MODIFY `product_name` TEXT NULL");
    }

    public function down(): void
    {
        if (! Schema::hasTable('product_certificates') || ! Schema::hasColumn('product_certificates', 'product_name')) {
            return;
        }

        $table = DB::getTablePrefix().'product_certificates';
        DB::statement("ALTER TABLE `{$table}` MODIFY `product_name` VARCHAR(255) NULL");
    }
};
