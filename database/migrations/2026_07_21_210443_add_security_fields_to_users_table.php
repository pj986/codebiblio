<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'login_attempts')) {

            Schema::table('users', function (Blueprint $table) {
                $table->integer('login_attempts')->default(0);
                $table->timestamp('blocked_until')->nullable();
            });

        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['login_attempts', 'blocked_until']);
        });
    }
};