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
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user1_id")->constrained()->references('id')->on("users")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("user2_id")->constrained()->references('id')->on("users")->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean("isVisibleForUser1")->default(true);
            $table->boolean("isVisibleForUser2")->default(true);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dicussions');
    }
};
