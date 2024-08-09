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
        Schema::create('atk_master', function (Blueprint $table) {
            $table->id('id_atk');
            $table->string('atk_name');
            $table->string('atk_brand');
            $table->string('atk_stock')->nullable();
            $table->string('atk_unit');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atk_master');
    }
};
