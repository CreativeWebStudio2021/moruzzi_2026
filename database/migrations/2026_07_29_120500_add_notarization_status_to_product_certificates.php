<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_certificates', function (Blueprint $table) {
            $table->string('notarization_status', 30)->nullable()->after('notarization_notes');
            $table->timestamp('notarization_started_at')->nullable()->after('notarization_status');
            $table->text('notarization_error')->nullable()->after('notarization_started_at');
        });
    }

    public function down(): void
    {
        Schema::table('product_certificates', function (Blueprint $table) {
            $table->dropColumn([
                'notarization_status',
                'notarization_started_at',
                'notarization_error',
            ]);
        });
    }
};

