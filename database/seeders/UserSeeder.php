<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::query()
            ->create([
                'firstname' => 'Danick',
                'lastname' => 'DALOYA',
                'email' => 'blackm111@protonmail.ch',
                'password' => Hash::make('blackm111@protonmail.ch'),
                'email_verified_at' => now()
            ]);

        $admin->assignRole(RolesEnum::ADMIN);

        $user = User::query()
            ->create([
                'firstname' => 'Danick',
                'lastname' => 'USER',
                'email' => 'user@ada.de',
                'password' => Hash::make('user@ada.de'),
                'email_verified_at' => now()
            ]);

        $user->assignRole(RolesEnum::USER);
    }
}
