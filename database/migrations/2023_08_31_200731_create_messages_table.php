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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text("contenu");
            $table->foreignId("sender_id")->constrained()->references('id')->on("users")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("receiver_id")->constrained()->references('id')->on("users")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("discussion_id")->constrained()->references('id')->on("dicussions")->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean("isVisibleForSender")->default(true);
            $table->boolean("isVisibleForReceiver")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
