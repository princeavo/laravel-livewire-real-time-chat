<?php

use App\Models\Groupe;
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
        Schema::create('groupes_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Groupe::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->text("contenu");
            $table->foreignId("sender_id")->constrained()->references('id')->on("users")->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupes_messages');
    }
};
