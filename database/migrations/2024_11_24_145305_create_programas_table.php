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
        Schema::create('programas', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre_programa');
            $table->unsignedBigInteger('tipo_programa');
            $table->unsignedBigInteger('facultadId')->nullable();
            $table->unsignedBigInteger('carreraId')->nullable();
            $table->date('fecha_programa');
            $table->string('institucion');
            $table->foreign('facultadId')->references('id')->on('facultades');
            $table->foreign('carreraId')->references('id')->on('carreras');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programas');
    }
};
