<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_certificates', function (Blueprint $table) {
            $table->string('pdf_filename')->nullable()->after('image_filename');
            $table->string('pdf_sha256', 64)->nullable()->after('pdf_filename');
            $table->date('issued_on')->nullable()->after('pdf_sha256');

            $table->unsignedSmallInteger('score_conservazione')->nullable()->after('issued_on');
            $table->unsignedSmallInteger('score_rarita')->nullable()->after('score_conservazione');
            $table->unsignedSmallInteger('score_battuta')->nullable()->after('score_rarita');
            $table->unsignedSmallInteger('score_metallo')->nullable()->after('score_battuta');
            $table->unsignedSmallInteger('score_stile')->nullable()->after('score_metallo');
            $table->unsignedSmallInteger('score_provenienza')->nullable()->after('score_stile');

            $table->string('notarization_hash', 66)->nullable()->after('score_provenienza');
            $table->string('notarization_tx_hash', 66)->nullable()->after('notarization_hash');
            $table->timestamp('notarized_at')->nullable()->after('notarization_tx_hash');
            $table->string('notarization_notes', 500)->nullable()->after('notarized_at');
        });
    }

    public function down(): void
    {
        Schema::table('product_certificates', function (Blueprint $table) {
            $table->dropColumn([
                'pdf_filename',
                'pdf_sha256',
                'issued_on',
                'score_conservazione',
                'score_rarita',
                'score_battuta',
                'score_metallo',
                'score_stile',
                'score_provenienza',
                'notarization_hash',
                'notarization_tx_hash',
                'notarized_at',
                'notarization_notes',
            ]);
        });
    }
};
