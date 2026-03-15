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
        Schema::create('plantaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parcela_id')->constrained('parcelas')->onDelete('restrict');
            $table->foreignId('variedad_id')->constrained('variedades')->onDelete('restrict');
            $table->foreignId('campania_id')->constrained('campanias')->onDelete('restrict');
            $table->date('fecha_siembra');
            $table->integer('numero_plantas');
            $table->date('fecha_fin')->nullable();
            $table->enum('estado', ['planificada', 'activa', 'finalizada']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantaciones');
    }
};
