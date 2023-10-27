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
        Schema::create('users_bloqueds', function (Blueprint $table) {
            $table->foreignId('user_who_has_blocked')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_blocked')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();

            $table->primary(['user_who_has_blocked','user_blocked']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_bloqueds');
    }
};
