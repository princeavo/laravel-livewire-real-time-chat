<?php

namespace Database\Factories;

use App\Models\Discussion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discussion>
 */
class DiscussionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $id1 = User::inRandomOrder()->first()->id;
        $id2 = User::inRandomOrder()->first()->id;
        while ($id1 == $id2) {
            $id2 = User::inRandomOrder()->first()->id;
        }

        // dd(Discussion::where('user2_id', '=', $id1)->where('user1_id', '=', $id2)->get()->first());

        while (Discussion::where('user2_id', '=', $id1)->where('user1_id', '=', $id2)->get()->first() || Discussion::where('user1_id', '=', $id1)->where('user2_id', '=', $id2)->get()->first()) {
            $id1 = User::inRandomOrder()->first()->id;
            $id2 = User::inRandomOrder()->first()->id;
            while ($id1 == $id2) {
                $id2 = User::inRandomOrder()->first()->id;
            }
        }

        return [
            "user1_id" => $id1,
            "user2_id" => $id2,
        ];
    }
}
