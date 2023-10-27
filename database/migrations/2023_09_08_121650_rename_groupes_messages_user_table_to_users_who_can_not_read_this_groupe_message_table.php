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
        Schema::table('groupes_messages_user', function (Blueprint $table) {
            $table->rename('users_who_can_not_read_this_groupe_message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('groupes_messages_user', function (Blueprint $table) {
            $table->rename('groupes_messages_user');
        });
    }
};
