<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => RolesEnum::ADMIN->value]);
        Role::create(['name' => RolesEnum::USER->value]);
        Role::create(['name' => RolesEnum::RESTAURANT->value]);
        Role::create(['name' => RolesEnum::STORE->value]);
    }
}
