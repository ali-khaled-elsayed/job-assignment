<?php

namespace App\Modules\Order;

use App\Http\Controllers\Controller;
use App\Modules\Order\Requests\CreateOrderRequest;
use App\Modules\Order\Rresources\OrderResource;
use App\Modules\Order\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {
    }

    public function store(CreateOrderRequest $request)
    {
        $order = $this->orderService->createOrder($request->validated());
        return successJsonResponse(new OrderResource($order), __('order.success.create_order'));
    }
}
