<?php

namespace Database\Factories;

use App\Models\Statut;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Adherant>
 */
class AdherentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            // 'image' => $this->faker->image(storage_path('app/public/image'), 300, 300),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'cin' => "AB12345",
            'sexe' => $this->faker->randomElement(['homme', 'femme']),
            'date_of_birth' => $this->faker->date(),
            'date_of_membership' => $this->faker->date(),
            'address' => $this->faker->address(),
            'tel' => $this->faker->regexify('^0\d{9}$'),
            'email' => $this->faker->email(),
            'region' => "souss",
            'city' => "taroudant",
            'statut_id' => Statut::all()->random()->id
        ];
    }
}
