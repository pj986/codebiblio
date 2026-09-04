<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('security_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // LOGIN_SUCCESS, LOGIN_FAILED, NEW_IP, ACCOUNT_BLOCKED...
            $table->string('event');

            $table->string('ip_address', 45)->nullable();

            $table->text('user_agent')->nullable();

            // Informations supplémentaires éventuelles
            $table->json('details')->nullable();

            $table->timestamps();

            $table->index('event');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_logs');
    }
};