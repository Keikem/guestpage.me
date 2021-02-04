<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@mymail.com',
            'password' => Hash::make('adminpassword'),
            'role' => 2
        ]);

        User::create([
            'name' => 'user1',
            'email' => 'user1@mymail.com',
            'password' => Hash::make('password'),
            'role' => 1
        ]);

        Comment::create([
            'title' => 'Default comment',
            'content' => 'Bla bla bla bla',
            'owner_id' => null
        ]);
    }
}
