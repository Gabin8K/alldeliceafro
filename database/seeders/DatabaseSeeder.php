<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\Article;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            // ...
        ]);

//        $restaurantUser = User::query()
//            ->create([
//                'firstname' => 'Danick',
//                'lastname' => 'DALOYA',
//                'email' => 'restaurant@ada.de',
//                'password' => Hash::make('restaurant@ada.de'),
//                'email_verified_at' => now()
//            ]);
//        $restaurantUser->assignRole(RolesEnum::RESTAURANT);
//        Restaurant::factory()->has(
//            Product::factory()->has(
//                Image::factory()->count(3),
//                'images'
//            )->count(50)
//        )->for($restaurantUser)->create();
//
//        Category::factory()
//            ->has(
//                Image::factory()->count(1),
//                'image'
//            )
//            ->has(
//                Article::factory()->has(
//                    Image::factory()->count(3),
//                    'images'
//                )->count(50)
//            )
//            ->count(20)
//            ->create();
//
//        Shop::factory()
//            ->has(
//                Image::factory()->count(1),
//                'image'
//            )
//            ->count(50)
//            ->create();
    }
}
