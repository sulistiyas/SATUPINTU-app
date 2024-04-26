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
        Schema::create('pr', function (Blueprint $table) {
            $table->id('id_pr');
            $table->string('pr_no');
            $table->foreignId('id_jn')->references('id_jn')->on('jobnumber')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_employee')->references('id_employee')->on('employee')->onUpdate('cascade')->onDelete('cascade');
            $table->string('pr_desc');
            $table->string('pr_qty');
            $table->string('pr_unit');
            $table->string('pr_status');
            $table->date('pr_date');
            $table->foreignId('id_manager')->references('id_employee')->on('employee')->onUpdate('cascade')->onDelete('cascade');
            $table->string('pr_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pr');
    }
};
