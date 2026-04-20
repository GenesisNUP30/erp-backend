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
        Schema::create('ventas_diarias', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->foreignId('cosecha_id')->constrained('cosechas')->onDelete('restrict');
            $table->decimal('kilos_primera', 10, 2);
            $table->decimal('precio_primera', 8, 2);
            $table->decimal('kilos_industria', 10, 2);
            $table->decimal('precio_industria', 8, 2);
            $table->decimal('importe_total', 12, 2);
            $table->enum('estado', ['pendiente', 'cobrada', 'anulada'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas_diarias');
    }
};
