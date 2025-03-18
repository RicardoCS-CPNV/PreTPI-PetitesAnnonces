<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add some users
        $users = [
            ['name' => 'Ricardo', 'email' => 'ricardo@gmail.com'],
            ['name' => 'Samuel', 'email' => 'samuel@gmail.com'],
            ['name' => 'Amer', 'email' => 'amer@gmail.com'],
            ['name' => 'Santi', 'email' => 'santi@gmail.com'],
            ['name' => 'Dany', 'email' => 'dany@gmail.com'],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('passwordpassword' . strtolower($user['name'])), // Hash du mot de passe
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
