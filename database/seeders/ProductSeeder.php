<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $burger = Product::updateOrCreate(
            ['name' => 'Burger']
        );

        $ingredients = [
            'Beef' => 150,
            'Cheese' => 30,
            'Onion' => 20,
        ];

        foreach ($ingredients as $name => $quantity) {
            $ingredient = Ingredient::where('name', $name)->first();

            if ($ingredient) {
                $burger->ingredients()->syncWithoutDetaching([
                    $ingredient->id => ['quantity_grams' => $quantity],
                ]);
            }
        }

    }
}
