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
        Schema::create('consumo_agua', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parcela_id')->constrained('parcelas')->onDelete('restrict');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->decimal('litros_consumidos', 12, 2);
            $table->enum('estado', ['estimado', 'real', 'anulado'])->default('real');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumo_agua');
    }
};
