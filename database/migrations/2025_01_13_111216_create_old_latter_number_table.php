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
        Schema::create('tbl_letter_number_2018', function (Blueprint $table) {
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
            $table->string('log_date');
        });

        Schema::create('tbl_letter_number_2019', function (Blueprint $table) {
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
            $table->string('log_date');
        });

        Schema::create('tbl_letter_number_2020', function (Blueprint $table) {
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
            $table->string('log_date');
        });

        Schema::create('tbl_letter_number_2021', function (Blueprint $table) {
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
            $table->string('log_date');
        });

        Schema::create('tbl_letter_number_2022', function (Blueprint $table) {
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
            $table->string('log_date');
        });

        Schema::create('tbl_letter_number_2023', function (Blueprint $table) {
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
            $table->string('log_date');
        });

        Schema::create('tbl_letter_number_2024', function (Blueprint $table) {
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
            $table->string('log_date');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_letter_number_2018');
        Schema::dropIfExists('tbl_letter_number_2019');
        Schema::dropIfExists('tbl_letter_number_2020');
        Schema::dropIfExists('tbl_letter_number_2021');
        Schema::dropIfExists('tbl_letter_number_2022');
        Schema::dropIfExists('tbl_letter_number_2023');
        Schema::dropIfExists('tbl_letter_number_2024');
    }
};
