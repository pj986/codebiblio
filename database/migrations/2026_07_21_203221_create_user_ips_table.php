<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_ips', function (Blueprint $table) {
            $table->id();

            // 👤 utilisateur lié
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // 🌐 adresse IP
            $table->string('ip');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_ips');
    }
};