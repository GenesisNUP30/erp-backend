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
        Schema::create('cosechas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plantacion_id')->constrained('plantaciones')->onDelete('restrict');
            $table->foreignId('campania_id')->constrained('campanias')->onDelete('restrict');
            $table->string('nombre_cosecha');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->enum('estado', ['en_crecimiento', 'en_recoleccion', 'en_poda', 'finalizada']);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cosechas');
    }
};
