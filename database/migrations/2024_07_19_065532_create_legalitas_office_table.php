<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('legalitas_office', function (Blueprint $table) {
            $table->id('id_legalitas');
            $table->string('no_legalitas');
            $table->string('dokumen');
            $table->string('nama_perusahaan');
            $table->date('terbit');
            $table->date('berakhir');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legalitas_office');
    }
};
