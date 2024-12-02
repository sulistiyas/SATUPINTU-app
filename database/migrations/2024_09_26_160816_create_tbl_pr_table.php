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
        Schema::create('tbl_pr', function (Blueprint $table) {
            $table->id('id_pr');
            $table->string('pr_number');
            $table->string('job_number');
            $table->integer('id_vendor');
            $table->string('vendor');
            $table->string('vendor_cp');
            $table->string('request');
            $table->string('divisi');
            $table->string('description');
            $table->integer('quantity');
            $table->string('unit');
            $table->integer('price');
            $table->integer('total_price');
            $table->integer('status');
            $table->string('nama_manager');
            $table->string('qr_code');
            $table->string('remarks');
            $table->string('reason');
            $table->date('date');
            $table->string('po_number');
            $table->string('ref_quotation');
            $table->date('date_po');
            $table->integer('status_po');
            $table->string('approve_po');
            $table->integer('discount');
            $table->integer('tax');
            $table->integer('coba');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_pr');
    }
};
