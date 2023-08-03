<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rut' => fake()->unique()->isbn10(),
            'name' => fake()->name(),
            'lastname' => fake()->lastname(),
            'address_street' => fake()->streetName(),
            'address_number' => fake()->numberBetween(10, 2000),
            'address_commune' => fake()->streetName(),
            'address_city' => fake()->city(),
            'phone' => fake()->unique()->phoneNumber(),
        ];
    }
}
