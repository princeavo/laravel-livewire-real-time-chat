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
        Schema::create('messages_images', function (Blueprint $table) {
            $table->string('type'); // group ou discussion
            $table->unsignedBigInteger('id');
            $table->string('path');

            $table->primary(['type','id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages_images');
    }
};
