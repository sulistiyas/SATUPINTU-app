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
            $table->string('id_pr');
            $table->bigInteger('id_vendor')->unsigned()->nullable();
            $table->foreign('id_vendor')->references('id_vendor')->on('vendor')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignId('id_vendor')->references('id_vendor')->on('vendor')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->string('currency')->nullable();
            $table->float('price');
            $table->float('total_price');
            $table->date('po_date');
            $table->string('po_status');
            $table->string('po_approve');
            $table->float('po_disc_type')->nullable();
            $table->float('po_disc')->nullable();
            $table->float('po_tax')->nullable();
            $table->float('po_service_charge')->nullable();
            $table->float('po_delivery_fee')->nullable();
            $table->float('po_additional_charge')->nullable();
            $table->string('po_rev')->nullable();
            $table->string('po_notes')->nullable();
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
