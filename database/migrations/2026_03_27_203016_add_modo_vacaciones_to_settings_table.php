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
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('vacaciones_activo')->default(false);
            $table->date('vacaciones_inicio')->nullable();
            $table->date('vacaciones_fin')->nullable();
            $table->string('vacaciones_mensaje')->nullable();
            $table->boolean('vacaciones_pausar_presupuestos')->default(true);
            $table->boolean('vacaciones_pausar_recurrentes')->default(true);
            $table->boolean('vacaciones_pausar_notificaciones')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};
