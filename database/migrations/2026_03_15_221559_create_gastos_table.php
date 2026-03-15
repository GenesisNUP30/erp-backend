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
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categoria_gastos')->onDelete('restrict');
            $table->foreignId('cosecha_id')->constrained('cosechas')->onDelete('restrict');
            $table->date('fecha');
            $table->string('concepto');
            $table->decimal('importe', 12, 2);
            $table->decimal('horas_estimadas', 8, 2)->nullable();
            $table->enum('estado', ['pendiente', 'pagado', 'anulado'])->default('pendiente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};
