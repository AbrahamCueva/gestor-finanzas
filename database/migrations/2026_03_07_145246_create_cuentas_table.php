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
        Schema::create('cuentas', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');

            $table->enum('tipo_cuenta', [
                'banco',
                'efectivo',
                'billetera_digital',
                'ahorro',
            ]);

            $table->decimal('saldo_inicial', 12, 2)->default(0);
            $table->decimal('saldo_actual', 12, 2)->default(0);

            $table->string('moneda')->default('PEN');

            $table->text('descripcion')->nullable();

            $table->boolean('activa')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentas');
    }
};
