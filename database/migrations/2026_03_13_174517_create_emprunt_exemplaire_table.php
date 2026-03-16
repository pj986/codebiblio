<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('emprunt_exemplaire', function (Blueprint $table) {

        $table->id();

        $table->foreignId('emprunt_id')
              ->constrained('emprunts')
              ->onDelete('cascade');

        $table->foreignId('exemplaire_id')
              ->constrained('exemplaires')
              ->onDelete('cascade');

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprunt_exemplaire');
    }
};
