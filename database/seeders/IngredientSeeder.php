<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = [
            ['name' => 'Beef', 'stock_quantity' => 20000],   // 20 kg
            ['name' => 'Cheese', 'stock_quantity' => 5000],  // 5 kg
            ['name' => 'Onion', 'stock_quantity' => 1000],   // 1 kg
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::updateOrCreate(
                ['name' => $ingredient['name']],
                [
                    'initial_quantity' => $ingredient['stock_quantity'],
                    'stock_quantity' => $ingredient['stock_quantity'],
                ]
            );
        }
    }
}
