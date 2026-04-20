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
        Schema::create('horas_trabajadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('cosecha_id')->nullable()->constrained('cosechas')->onDelete('set null');
            $table->foreignId('pago_id')->nullable()->constrained('pagos')->onDelete('set null');
            $table->date('fecha');
            $table->decimal('horas', 8, 2);
            $table->decimal('precio_hora', 10, 2);
            $table->string('tipo_trabajo');
            $table->timestamps();
            $table->softDeletes();

            $table->index('fecha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horas_trabajadas');
    }
};
