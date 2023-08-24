<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('users')->insert([
            'type' => "ADMIN",
            'name' => "Demo Admin",
            'username' => "admin",
            "email" => "admin@metatige.com",
            "phone" => "111111111",
            "default_screen" => "admin",
            "password" => Hash::make('1234567')
        ]);

        DB::table('users')->insert([
            'type' => "USER",
            'name' => "Demo User",
            'username' => "user",
            "phone" => "111111112",
            "email" => "user@metatige.com",
            "default_screen" => "staff",
            "password" => Hash::make('1234567')
        ]);
        
    }
}
