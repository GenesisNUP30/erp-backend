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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('mes');
            $table->integer('anio');
            $table->decimal('total_horas', 10, 2);
            $table->decimal('monto_total', 12, 2);
            $table->enum('estado', ['borrador', 'validado', 'pagado', 'archivado']);
            $table->date('fecha_pago')->nullable();
            $table->timestamps();

            // Índices solicitados
            $table->index(['mes', 'anio']);
            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
