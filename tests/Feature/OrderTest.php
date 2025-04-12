<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Ingredient;
use App\Mail\LowStockAlert;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_creation_and_stock_update()
    {
        Mail::fake();
    
        $product = Product::factory()->hasAttached(
            Ingredient::factory()->count(3),
            ['quantity_grams' => 150] // grams
        )->create();
    
        $response = $this->postJson('/api/orders', [
            'products' => [
                ['product_id' => $product->id, 'quantity' => 2],
            ],
        ]);
    
        $response->assertStatus(200);
    
        foreach ($product->ingredients as $ingredient) {
            $ingredient->refresh();
            $expectedStock = $ingredient->initial_quantity - (2 * $ingredient->pivot->quantity_grams);
            $this->assertEquals($expectedStock, $ingredient->stock_quantity);
        }
    
        // Assert mail was sent if below 50%
        Mail::assertSent(LowStockAlert::class);
    }    

}
