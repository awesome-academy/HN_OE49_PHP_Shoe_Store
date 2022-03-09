<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\UpdateRequest;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('user', 'products', 'orderStatus')->paginate(config('paginate.pagination'));

        return view('admins.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('admins.orders.detail', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        if ($order->order_status_id == config('orderstatus.delivered')
            || $order->order_status_id == config('orderstatus.cancelled')) {
            return redirect()->route('orders.index')->with('error', __('error update status'));
        }
        $statuses = OrderStatus::all();

        return view('admins.orders.edit', compact('order', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Order $order)
    {
        if ($request->order_status_id == config('orderstatus.cancelled')) {
            foreach ($order->products as $product) {
                $product->quantity += $product->pivot->quantity;
                $product->update();
            }
        }
        $order->update($request->only('order_status_id'));

        return redirect()->route('orders.index')
            ->with('message', __('update order success', ['value' => '#'.$order->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
