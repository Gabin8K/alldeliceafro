<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'name_to_store' => fake()->firstName(),
            'path' => 'https://loremflickr.com/400/400/food',
            'url' => 'https://loremflickr.com/400/400/food',
            'size' => random_int(1000, 10000),
        ];
    }
}
