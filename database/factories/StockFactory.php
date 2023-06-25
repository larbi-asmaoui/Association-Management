<?php

namespace Database\Factories;

use App\Models\StockType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->name(),
            "stock_type_id" => StockType::all()->random()->id,
            "purchase_date" => $this->faker->date(),
            "quantity" => $this->faker->randomDigit(),
            "price_per_unit" => $this->faker->randomFloat(2, 0, 1000),

        ];
    }
}
