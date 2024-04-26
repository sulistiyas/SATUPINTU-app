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
        Schema::create('employee', function (Blueprint $table) {
            $table->id('id_employee');
            $table->foreignId('id_users')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('personal_email');
            $table->string('emp_position');
            $table->string('emp_division');
            $table->string('place_birth');
            $table->date('birth_date');
            $table->string('sex');
            $table->string('nik')->nullable();
            $table->string('npwp')->nullable();
            $table->string('bank_acc')->nullable();
            $table->string('bpjs_kes')->nullable();
            $table->string('bpjs_ket')->nullable();
            $table->string('date_joined');
            $table->string('status_kontrak');
            $table->string('status_nikah');
            $table->string('emp_address');
            $table->string('emp_phone');
            $table->string('emp_phone_emergency')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};
