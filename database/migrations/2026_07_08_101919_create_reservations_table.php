<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            // 👤 utilisateur
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // 📚 livre
            $table->foreignId('livre_id')->constrained()->cascadeOnDelete();

            // 📅 date réservation
            $table->timestamp('date_reservation')->useCurrent();

            // 📌 statut
            $table->enum('statut', ['en_attente', 'honoree', 'annulee'])
                  ->default('en_attente');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};