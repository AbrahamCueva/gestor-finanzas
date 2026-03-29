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
        if (!Schema::hasTable('push_subscriptions')) {
            Schema::create('push_subscriptions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id'); // ← sin constrained()
                $table->text('endpoint');
                $table->text('public_key');
                $table->text('auth_token');
                $table->timestamps();
            });
        } else {
            // Si ya existe, solo agrega el unique si no existe
            if (!Schema::hasIndex('push_subscriptions', 'push_user_endpoint')) {
                Schema::table('push_subscriptions', function (Blueprint $table) {
                    $table->unique(['user_id', 'endpoint'], 'push_user_endpoint');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('push_subscriptions');
    }
};
