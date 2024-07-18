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
        Schema::create('office_asset', function (Blueprint $table) {
            $table->id('id_asset');
            $table->string('asset_code');
            $table->string('id_device');
            $table->integer('qty');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->date('purchase_date');
            $table->integer('price')->nullable();
            $table->string('kondisi');
            $table->string('id_employee');
            $table->string('device_location');
            $table->string('desc')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_asset');
    }
};
