<?php

namespace Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = Faker::create();

        return [
            'code' => 'BR-' . $faker->unique()->numberBetween($min = 1, $max = 10000),
            'name' => $faker->company,
            'description' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        ];
    }
}
