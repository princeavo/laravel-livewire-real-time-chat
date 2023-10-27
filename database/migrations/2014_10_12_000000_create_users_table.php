<?php

use App\Models\Pays;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('lastname');
            $table->string('firstname');
            $table->date("date_de_naissance");
            $table->string('profile_photo')->default('man.png');
            $table->enum("genre",["man","woman"]);
            $table->foreignIdFor(Pays::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('email')->unique();
            $table->string('contact')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string("unlockScreenCode")->nullable();
            $table->boolean("lockScreen")->default(false);
            $table->enum("mode",["sombre","clair"])->default('clair');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
