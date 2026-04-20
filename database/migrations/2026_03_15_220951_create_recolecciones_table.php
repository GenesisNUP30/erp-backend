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
        Schema::create('recolecciones', function (Blueprint $table) {
            // Campo de clave primaria (PK) autoincremental
            $table->id();
            // Campo de clave foránea (FK) a la tabla "cosechas". Se elimina en cascada si se borra la cosecha.
            $table->foreignId('cosecha_id')->constrained('cosechas')->onDelete('restrict');
            // Campo de clave foránea (FK) a la tabla "users". Puede ser null y se establece a null si se elimina el usuario.
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            // Fecha en la que se registra la recolección. Si no se especifica, se utiliza la fecha actual.
            $table->date('fecha')->useCurrent();
            // Número de cajas recolectadas
            $table->integer('num_cajas');
            // Peso en kilos por cada caja
            $table->decimal('kilos_caja', 8, 2);
            // Estado de la recolección
            $table->enum('estado', ['registrada', 'verificada', 'anulada'])->default('registrada');
            // Notas u observaciones adicionales
            $table->text('notas')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recolecciones');
    }
};
