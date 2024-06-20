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
            'name'          => fake()->name(),
            'email'         => fake()->unique()->safeEmail(),
            'phone'         => fake()->e164PhoneNumber(),
            'address'       => fake()->streetName(),
            'num_ext'       => fake()->randomNumber(4),
            'num_int'       => fake()->randomNumber(2),
        ];
    }
}
