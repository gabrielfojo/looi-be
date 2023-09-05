<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user1 = User::factory()->create(['name' => 'user1', 'password' => bcrypt('1234'), 'email' => 'user1@fake.com']);
        $user2 = User::factory()->create(['name' => 'user2', 'password' => bcrypt('1234'), 'email' => 'user2@fake.com']);

        Todo::factory()
            ->count(5)
            ->create(['user_id' => $user1->id]);

        Todo::factory()
            ->count(5)
            ->create(['user_id' => $user2->id]);
    }
}
