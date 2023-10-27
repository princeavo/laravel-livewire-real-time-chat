<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Discussion;
use App\Models\Groupe;
use App\Models\Message;
use App\Models\Pays;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Pays::factory(40)->create();
        // \App\Models\User::factory(40)->create();
        Groupe::factory(40)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


            // for ($i=0; $i < 1000; $i++) {
            //     DB::table("groupe_user")->insert([
            //         "groupe_id"   => Groupe::inRandomOrder()->first()->id,
            //         "user_id"   => Groupe::inRandomOrder()->first()->id,
            //         "isAdmin" => (int) rand(0,1)
            //     ]);
            // }

            // Discussion::factory(10)->create()->each(function ($discussion){
            //     $random = rand(0,1);
            //     Message::factory(50)->create([
            //         "sender_id" => ($random == 0) ? $discussion->user1_id : $discussion->user2_id,
            //         "receiver_id" => ($random == 1) ? $discussion->user1_id : $discussion->user2_id,
            //         "discussion_id" => $discussion->id
            //     ]);
            // });



    }
}
