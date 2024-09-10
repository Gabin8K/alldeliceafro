<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'name_en' => fake()->firstName() . ' ' . Str::random(),
            'name_fr' => fake()->lastName() . ' ' . Str::random(),
            'name_de' => fake()->name() . ' ' . Str::random(),
            'slug' => fake()->unique()->slug() . '-' . Str::random(),
            'description_en' => fake()->paragraph(5),
            'description_fr' => fake()->paragraph(5),
            'description_de' => fake()->paragraph(5),
            'weight' => random_int(1000, 10000),
        ];
    }
}
