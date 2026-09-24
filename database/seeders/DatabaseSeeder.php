<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // magazijn gebruiker aanmaken
        User::updateOrCreate(
            [
                'email' => 'magazijnmedewerker@jamin.nl',
            ],
            [
                'name' => 'Magazijnmedewerker',
                'password' => Hash::make('password'),
                'rolname' => 'magazijnmedewerker',
            ]
        );
    }
}