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
        Schema::create('client', function (Blueprint $table) {
            $table->id('id_client');
            $table->string('nama_perusahaan');
            $table->string('almt_perusahaan')->nullable();
            $table->string('npwp')->nullable();
            $table->string('almt_npwp')->nullable();
            $table->string('kodepos')->nullable();
            $table->string('kota')->nullable();
            $table->string('nama_up')->nullable();
            $table->string('jabatan_up')->nullable();
            $table->string('phone')->nullable();
            $table->string('username')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client');
    }
};
