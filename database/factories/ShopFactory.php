<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShopFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' ' . Str::random(),
            'slug' => fake()->unique()->slug() . '-' . Str::random(),
            'description_en' => fake()->paragraph(5),
            'description_fr' => fake()->paragraph(5),
            'description_de' => fake()->paragraph(5),
        ];
    }
}
