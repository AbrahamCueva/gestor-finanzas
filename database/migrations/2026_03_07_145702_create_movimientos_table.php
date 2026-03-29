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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_movimiento', [
                'ingreso',
                'egreso',
                'ajuste',
            ]);

            $table->foreignId('cuenta_id')
                ->constrained('cuentas');

            $table->foreignId('categoria_id')
                ->constrained('categorias');

            $table->foreignId('subcategoria_id')
                ->nullable()
                ->constrained('subcategorias');

            $table->decimal('monto', 12, 2);

            $table->date('fecha');

            $table->text('descripcion')->nullable();

            $table->string('referencia')->nullable();

            $table->boolean('es_recurrente')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
