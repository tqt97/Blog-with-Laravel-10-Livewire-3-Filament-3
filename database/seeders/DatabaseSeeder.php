<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = \App\Models\User::factory(10)->create();

        $posts = \App\Models\Post::factory(50)->recycle($users)->create();
        // \App\Models\Post::factory(100)->create();
        \App\Models\Category::factory(5)->create();
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Tuantq',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12341234'),
        ]);
    }
}
