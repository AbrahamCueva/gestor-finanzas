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
        Schema::create('deudas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->enum('tipo', ['debo', 'me_deben']);
            $table->decimal('monto_total', 12, 2);
            $table->decimal('monto_pagado', 12, 2)->default(0);
            $table->date('fecha_inicio');
            $table->date('fecha_vencimiento')->nullable();
            $table->string('acreedor_deudor');
            $table->enum('estado', ['pendiente', 'pagada', 'vencida'])->default('pendiente');
            $table->string('color')->nullable()->default('#fbbf24');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deudas');
    }
};
