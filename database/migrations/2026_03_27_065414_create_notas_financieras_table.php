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
        Schema::create('notas_financieras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('titulo');
            $table->text('contenido')->nullable();
            $table->string('color')->default('#fbbf24');
            $table->enum('tipo', ['nota', 'recordatorio', 'idea'])->default('nota');
            $table->boolean('fijada')->default(false);
            $table->timestamp('recordar_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas_financieras');
    }
};
