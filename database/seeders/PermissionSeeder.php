<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'permission-1']);
        Permission::create(['name' => 'permission-2']);
        Permission::create(['name' => 'permission-3']);
        Permission::create(['name' => 'permission-4']);
        Permission::create(['name' => 'permission-5']);
    }
}
