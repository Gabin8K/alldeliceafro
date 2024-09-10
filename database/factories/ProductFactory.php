<?php

namespace Database\Factories;

use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{

    /**
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'description' => fake()->paragraph(3),
            'price' => random_int(1000, 100000),
        ];
    }
}
