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
        Schema::create('opctrlnos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fac_id');
            $table->year('year');
            $table->unsignedInteger('number');
            $table->timestamps();

            $table->unique(['fac_id', 'year']);
        $table->foreign('fac_id')->references('fac_id')->on('tbl_facility')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opctrlnos');
    }
};
