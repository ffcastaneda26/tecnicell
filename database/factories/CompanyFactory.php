<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $company_name= fake()->company();
        $short=substr($company_name,0,10);
        return [
            'name'          => $company_name,
            'short'         => $short,
            'slug'          => Str::slug($company_name),
            'email'         => fake()->unique()->safeEmail(),
            'phone'         => fake()->phoneNumber(),
            'address'       => fake()->streetName(),
            'num_ext'       => fake()->randomNumber(4),
            'num_int'       => fake()->randomNumber(2),
            'user_id'       => 1,
        ];
    }
}
