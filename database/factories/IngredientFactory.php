<?php

namespace Database\Factories;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
{  protected $model = Ingredient::class;

    public function definition(): array
    {
        $initial = $this->faker->numberBetween(1000, 5000);

        return [
            'name' => $this->faker->word,
            'initial_quantity' => $initial,
            'stock_quantity' => $initial,
        ];
    }
}
