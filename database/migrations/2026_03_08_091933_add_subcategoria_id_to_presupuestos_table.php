<?php

use App\Models\Subcategoria;
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
            $table->foreignId('subcategoria_id')
                ->nullable()
                ->after('categoria_id')
                ->constrained('subcategorias')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->dropForeignIdFor(Subcategoria::class);
            $table->dropColumn('subcategoria_id');
        });
    }
};
