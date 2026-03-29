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
        Schema::create('lista_compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nombre');
            $table->integer('cantidad')->default(1);
            $table->decimal('precio_estimado', 10, 2)->nullable();
            $table->string('categoria')->nullable();
            $table->enum('prioridad', ['urgente', 'normal', 'puede_esperar']);
            $table->boolean('comprado')->default(false);
            $table->timestamp('comprado_en')->nullable();
            $table->timestamp('ultimo_recordatorio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_compras');
    }
};
