<?php

use App\Http\Middleware\Cors;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::middleware([Cors::class])->group(function () {
    Route::apiResource('orders', OrderController::class);
    Route::post('orders/{order}/restore', [OrderController::class, 'restore']);
});