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
        Schema::create('transferencias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cuenta_origen_id')
                ->constrained('cuentas')
                ->cascadeOnDelete();

            $table->foreignId('cuenta_destino_id')
                ->constrained('cuentas')
                ->cascadeOnDelete();

            $table->decimal('monto', 12, 2);

            $table->date('fecha');

            $table->text('descripcion')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transferencias');
    }
};
