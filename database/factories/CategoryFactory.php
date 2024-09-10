<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{

    /**
     * @inheritDoc
     */
    public function definition(): array
    {
        return [
            'name_en' => fake()->firstName() . ' ' . Str::random(),
            'name_fr' => fake()->lastName() . ' ' . Str::random(),
            'name_de' => fake()->name() . ' ' . Str::random(),
            'slug' => fake()->unique()->slug() . '-' . Str::random(),
        ];
    }
}
