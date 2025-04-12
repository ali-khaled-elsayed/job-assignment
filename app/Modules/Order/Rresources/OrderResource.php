<?php

namespace App\Modules\Order\Rresources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'order_id' => $this->id,
            'createdAt' => $this->created_at,
            'products' => $this->products->map(function ($product) {
                return [
                    'productId' => $product->id,
                    'name' => $product->name,
                    'quantity' => $product->pivot->quantity,
                ];
            }),
        ];
    }
}
