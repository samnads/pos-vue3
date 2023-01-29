<?php

namespace Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warehouse>
 */
class WarehouseFactory extends Factory
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
            'code' => 'WH-'.$faker->unique()->numberBetween($min = 1, $max = 10000),
            'name' => $faker->company,
            'place' => Str::random(20),
            'date_of_open' => $faker->date,
            'address' => $faker->address,
            'country_id' => 1,
            'phone' => $faker->phoneNumber(),
            'email' => Str::random(10) . '@gmail.com',
            'status_id' => $faker->randomElement([16, 17, 18, 19]),
            'status_reason' => Str::random(5),
        ];

    }
}
