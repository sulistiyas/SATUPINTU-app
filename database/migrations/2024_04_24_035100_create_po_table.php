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
        Schema::create('po', function (Blueprint $table) {
            $table->id('id_po');
            $table->string('po_no');
            $table->foreignId('id_pr')->references('id_pr')->on('pr')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_vendor')->references('id_vendor')->on('vendor')->onUpdate('cascade')->onDelete('cascade');
            $table->string('price');
            $table->string('total_price');
            $table->date('po_date');
            $table->string('po_status');
            $table->string('po_approve');
            $table->string('po_disc');
            $table->string('po_tax');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('po');
    }
};
