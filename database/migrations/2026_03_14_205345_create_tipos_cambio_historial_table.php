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
        Schema::create('tipos_cambio_historial', function (Blueprint $table) {
            $table->id();
            $table->string('moneda_base', 10);
            $table->string('moneda_destino', 10);
            $table->decimal('tasa', 12, 6);
            $table->date('fecha');
            $table->timestamps();

            $table->unique(['moneda_base', 'moneda_destino', 'fecha']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_cambio_historial');
    }
};
