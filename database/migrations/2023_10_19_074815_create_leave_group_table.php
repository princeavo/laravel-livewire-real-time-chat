<?php

use App\Models\Groupe;
use App\Models\User;
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
        Schema::create('leave_group', function (Blueprint $table) {
            $table->foreignIdFor(Groupe::class);
            $table->foreignIdFor(User::class);

            $table->primary(['groupe_id','user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_group');
    }
};
