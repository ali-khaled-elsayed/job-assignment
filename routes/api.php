<?php

use App\Modules\Order\OrderController;
use Illuminate\Support\Facades\Route;


Route::controller(OrderController::class)->prefix('orders')->group(function () {
    
    Route::post('', 'store');

    // Route::get('', 'getAllChannels');
    // Route::get('/{channelId}', 'getChannelById')
    // Route::put('{channelId}', 'updateChannel');
    // Route::put('{channelId}/toggle-status', 'toggleChannelStatus');
    // Route::post('{channelCode}/pull-orders', 'pullChannelOrders');
});