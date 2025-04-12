<?php

namespace  App\Modules\Order\Services;

use App\Mail\LowStockAlert;
use Illuminate\Support\Facades\Mail;
use App\Modules\Order\Repositories\OrderRepository;
use App\Modules\Order\Repositories\ProductRepository;

class OrderService
{
    public function __construct(private OrderRepository $orderRepository, private ProductRepository $productRepository)
    {
    }

    public function createOrder($request)
    {
        $order =  $this->orderRepository->create([]);

        $data = collect($request['products'])->mapWithKeys(function ($product) {
            return [$product['product_id'] => ['quantity' => $product['quantity']]];
        })->toArray();

        $order->products()->sync($data);

        // Update ingredient stock
        $this->updateGradients($request['products']);

        return $order;
    }

    public function updateGradients($products)
    {
         foreach ($products as $item) {
            $product = $this->productRepository->find($item['product_id']);

            foreach ($product->ingredients as $ingredient) {

                $totalRequired = $ingredient->pivot->quantity_grams * $item['quantity'];
                $ingredient->decrement('stock_quantity', $totalRequired);

                // Alert if stock below 50% and email not sent
                $alertQuantity = $ingredient->initial_quantity * 0.5;
                if ($ingredient->stock_quantity <= $alertQuantity && !$ingredient->low_quantity_alert) {
                    
                    // Send email
                    Mail::to(env('USER_EMAIL'))->queue(new LowStockAlert($ingredient));

                    // Mark sent
                    $ingredient->low_quantity_alert = true;
                }

                $ingredient->save();

            }
        }
    }

}
