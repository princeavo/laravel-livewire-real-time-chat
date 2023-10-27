<?php

namespace Database\Factories;

use App\Models\Groupe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Groupe>
 */
class GroupeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        for ($i = 0; $i < 10; $i++) {
            DB::table("groupes_messages")->insert([
                "groupe_id" => Groupe::inRandomOrder()->first()->id,
                "contenu" => $this->faker->text(),
                "sender_id" => User::inRandomOrder()->first()->id,
                "created_at" => now()
            ]);
        }

        return [
            "nom" => $this->faker->company(),
            "description" => $this->faker->text(),
            "creator_id" => User::inRandomOrder()->first()->id
        ];
    }
}
