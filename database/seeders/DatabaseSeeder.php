<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([PlayerSeeder::class]);

        \App\Models\User::updateOrCreate(
            ['email' => 'test@example.com'], // Si este email existe...
            [
                'name' => 'Test User',       // ...actualiza estos datos.
                'password' => bcrypt('password'), // Si no existe, lo crea.
            ]
        );
    }
}
