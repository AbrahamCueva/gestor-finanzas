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
        Schema::create('metas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('monto_objetivo', 12, 2);
            $table->decimal('monto_actual', 12, 2)->default(0);
            $table->date('fecha_limite')->nullable();
            $table->string('icono')->nullable()->default('heroicon-o-star');
            $table->string('color')->nullable()->default('#fbbf24');
            $table->boolean('completada')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metas');
    }
};
