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
        Schema::create('letter_number', function (Blueprint $table) {
            $table->id('id_letter');
            $table->string('nomor_surat');
            $table->string('nomor_urut');
            $table->string('tipe_srt');
            $table->string('comp');
            $table->string('kode_client')->nullable();
            $table->string('nama_perusahaan');
            $table->string('bln');
            $table->string('thn');
            $table->string('username');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_number');
    }
};
