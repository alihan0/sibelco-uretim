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

        DB::table('facility')->insert([
            "title" => "Tesis 1"
        ]);
        DB::table('facility')->insert([
            "title" => "Tesis 2"
        ]);
        DB::table('facility')->insert([
            "title" => "Tesis 3"
        ]);

        DB::table('units')->insert([
            "facility" => 1,
            "title" => "Birim 1"
        ]);
        DB::table('units')->insert([
            "facility" => 1,
            "title" => "Birim 2"
        ]);
        DB::table('units')->insert([
            "facility" => 1,
            "title" => "Birim 3"
        ]);
        DB::table('units')->insert([
            "facility" => 2,
            "title" => "Birim 1"
        ]);
        DB::table('units')->insert([
            "facility" => 2,
            "title" => "Birim 2"
        ]);
        DB::table('units')->insert([
            "facility" => 2,
            "title" => "Birim 3"
        ]);
        DB::table('units')->insert([
            "facility" => 3,
            "title" => "Birim 1"
        ]);
        DB::table('units')->insert([
            "facility" => 3,
            "title" => "Birim 2"
        ]);
        DB::table('units')->insert([
            "facility" => 3,
            "title" => "Birim 3"
        ]);
        DB::table('forms')->insert([
            "title" => "Test Form 1",
            "detail" => "Test form detayları",
            "to_emails" => "alihanozturk364@gmail.com,yottabeetr@gmail.com",
            "status" => 1
        ]);
        DB::table('form_questions')->insert([
            "form" => 1,
            "align" => 1,
            "title" => "Soru Başlığı 1",
            "confirmation" => 0,
            "question" => "Soru 1",
            "status" => 1
        ]);
        DB::table('form_questions')->insert([
            "form" => 1,
            "align" => 2,
            "title" => "Soru Başlığı 2",
            "confirmation" => 0,
            "question" => "Soru 2",
            "status" => 1
        ]);
    }
}
