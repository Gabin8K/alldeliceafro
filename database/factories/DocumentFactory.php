<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    /**
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'name_to_store' => fake()->firstName(),
            'type' => 'picture',
            'url' => 'https://picsum.photos/300',
            'size' => random_int(1000, 10000),
        ];
    }
}
