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
        Schema::create('atk_log', function (Blueprint $table) {
            $table->id('id_atk_log');
            $table->string('log_type');
            $table->string('id_atk');
            $table->string('qty_log');
            $table->date('date_log');
            $table->time('time_log');
            $table->time('id_employee');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atk_log');
    }
};
