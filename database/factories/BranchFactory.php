<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $branch_name= fake()->company();
        $short=substr($branch_name,0,10);
        $user = User::role(env('APP_ROL_TO_SUSCRIPTOR','Gerente'))->first();
        $company = Company::first();
        return [
            'company_id'    => $company->id,
            'name'          => $branch_name,
            'short'         => $short,
            'slug'          => Str::slug($branch_name),
            'email'         => fake()->unique()->safeEmail(),
            'phone'         => fake()->e164PhoneNumber(),
            'address'       => fake()->streetName(),
            'num_ext'       => fake()->randomNumber(4),
            'num_int'       => fake()->randomNumber(2),
            'user_id'       => $user->id,
        ];

    }
}
