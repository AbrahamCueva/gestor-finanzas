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
        Schema::create('inflacion_peruana', function (Blueprint $table) {
            $table->id();
            $table->integer('anio');
            $table->integer('mes');
            $table->decimal('tasa_mensual', 6, 4);
            $table->decimal('tasa_anual', 6, 4)->nullable();
            $table->string('fuente')->default('BCRP');
            $table->timestamps();

            $table->unique(['anio', 'mes']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inflacion_peruana');
    }
};
