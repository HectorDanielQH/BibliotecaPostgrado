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
        Schema::create('trabajosfinales', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre_trabajo');
            $table->string('Nombre_autor');
            $table->unsignedBigInteger('programaId');
            $table->foreign('programaId')->references('id')->on('programas');
            $table->string('codigo')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trabajosfinales');
    }
};
