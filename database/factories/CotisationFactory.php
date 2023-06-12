<?php

namespace Database\Factories;

use App\Models\Adherent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cotisation>
 */
class CotisationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'adherent_id' => Adherent::all()->random()->id,
            'montant' => $this->faker->randomFloat(2, 0, 1000),
            'type' => $this->faker->randomElement(['espece', 'cheque', 'virement']),
            'cotisation_date' => $this->faker->date(),
        ];
    }
}
