<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // gebruikers met rollen aanmaken
        $gebruikers = [
            [
                'name' => 'Trainer',
                'email' => 'trainer@jamin.nl',
                'password' => 'password',
                'rolname' => 'trainer',
            ],
            [
                'name' => 'Medewerker',
                'email' => 'medewerker@jamin.nl',
                'password' => 'password',
                'rolname' => 'medewerker',
            ],
            [
                'name' => 'Magazijnmedewerker',
                'email' => 'magazijnmedewerker@jamin.nl',
                'password' => 'password',
                'rolname' => 'magazijnmedewerker',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@jamin.nl',
                'password' => 'password',
                'rolname' => 'admin',
            ],
            [
                'name' => 'Productmanager',
                'email' => 'productmanager@jamin.nl',
                'password' => 'password',
                'rolname' => 'productmanager',
            ],
            [
                'name' => 'Planner',
                'email' => 'planner@jamin.nl',
                'password' => 'password',
                'rolname' => 'planner',
            ],
        ];

        // alle gebruikers opslaan in db
        foreach ($gebruikers as $gebruiker) {
            User::updateOrCreate(
                ['email' => $gebruiker['email']],
                [
                    'name' => $gebruiker['name'],
                    'password' => Hash::make($gebruiker['password']),
                    'rolname' => $gebruiker['rolname'],
                ]
            );
        }
    }
}
