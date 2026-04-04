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
        Schema::create('retos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('tipo'); // ahorro, egreso_categoria, sin_gastos, ingreso, dias_consecutivos
            $table->string('icono')->default('🎯');
            $table->string('color')->default('#fbbf24');
            $table->decimal('meta_monto', 12, 2)->nullable();
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->integer('meta_dias')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->enum('dificultad', ['facil', 'medio', 'dificil', 'extremo'])->default('medio');
            $table->integer('puntos')->default(100);
            $table->enum('estado', ['activo', 'completado', 'fallido', 'abandonado'])->default('activo');
            $table->decimal('progreso_actual', 12, 2)->default(0);
            $table->timestamp('completado_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retos');
    }
};
