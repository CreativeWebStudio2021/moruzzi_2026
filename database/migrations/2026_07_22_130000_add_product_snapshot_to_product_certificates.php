<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_certificates', function (Blueprint $table) {
            if (! Schema::hasColumn('product_certificates', 'product_sku')) {
                $table->string('product_sku', 64)->nullable()->after('product_id');
            }
            if (! Schema::hasColumn('product_certificates', 'product_name')) {
                $table->string('product_name')->nullable()->after('product_sku');
            }
        });

        $table = DB::getTablePrefix().'product_certificates';
        DB::statement("ALTER TABLE `{$table}` MODIFY product_id BIGINT UNSIGNED NULL");
    }

    public function down(): void
    {
        Schema::table('product_certificates', function (Blueprint $table) {
            if (Schema::hasColumn('product_certificates', 'product_sku')) {
                $table->dropColumn('product_sku');
            }
            if (Schema::hasColumn('product_certificates', 'product_name')) {
                $table->dropColumn('product_name');
            }
        });

        $table = DB::getTablePrefix().'product_certificates';
        DB::statement("ALTER TABLE `{$table}` MODIFY product_id BIGINT UNSIGNED NOT NULL");
    }
};
