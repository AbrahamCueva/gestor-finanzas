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
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->date('fecha_inicio')->after('anio');
            $table->date('fecha_fin')->after('fecha_inicio');
            $table->dropColumn(['mes', 'anio']); // ya no los necesitamos
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
        $table->dropColumn(['fecha_inicio', 'fecha_fin']);
        $table->integer('mes')->nullable();
        $table->integer('anio');
    });
    }
};
