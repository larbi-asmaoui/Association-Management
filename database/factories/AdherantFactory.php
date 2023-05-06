<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Adherant>
 */
class AdherantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'cin' => "AB12345",
            'sexe' => Str::random(5),
            'date_of_birth' => $this->faker->date(),
            'address' => $this->faker->address(),
            'tel' => $this->faker->regexify('^0\d{9}$'),
            'email' => $this->faker->email(),
        ];
    }
}
