<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return OrderResource::collection(Order::withTrashed()->paginate(5));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStoreRequest $request)
    {
        $order = Order::create($request->validated());
        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new OrderResource(Order::withTrashed()->findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderStoreRequest $request, string $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->validated());

        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->active = false;
        $order->save();
        $order->delete();
        
        return response()->json(['message' => 'Order Deleted successfully.']);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id) {
        $order = Order::withTrashed()->findOrFail($id);
        $order->active = true;
        $order->save();
        $order->restore();

        return response()->json(['message' => 'Order restored successfully.']);
    }
}
