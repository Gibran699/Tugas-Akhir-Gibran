<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'id'                => Str::uuid(),
                'name'              => 'Zukaro',
                'email_verified_at' => now(),
                'password'          => Hash::make('password123'),
                'remember_token'    => Str::random(10),
            ]
        );

        // Pastikan user admin selalu punya role admin
        if ($user->roles->isEmpty()) {
            $user->assignRole('admin');
        }
    }
}
