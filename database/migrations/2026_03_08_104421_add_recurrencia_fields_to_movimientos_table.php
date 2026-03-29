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
        Schema::table('movimientos', function (Blueprint $table) {
            $table->enum('frecuencia_recurrencia', ['diario', 'semanal', 'mensual'])
                ->nullable()
                ->after('es_recurrente');
            $table->date('fecha_fin_recurrencia')
                ->nullable()
                ->after('frecuencia_recurrencia');
            $table->date('ultima_ejecucion')
                ->nullable()
                ->after('fecha_fin_recurrencia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movimientos', function (Blueprint $table) {
            $table->dropColumn(['frecuencia_recurrencia', 'fecha_fin_recurrencia', 'ultima_ejecucion']);
        });
    }
};
