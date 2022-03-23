<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\UpdateRequest;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderStatus\OrderStatusRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    protected $orderRepo;
    protected $orderStatusRepo;
    protected $productRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepo,
        OrderStatusRepositoryInterface $orderStatusRepo,
        ProductRepositoryInterface $productRepo
    ) {
        $this->orderRepo = $orderRepo;
        $this->orderStatusRepo = $orderStatusRepo;
        $this->productRepo = $productRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orderRepo->getOrder();

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
    public function show($id)
    {
        $order = $this->orderRepo->find($id);

        return view('admins.orders.detail', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = $this->orderRepo->find($id);
        if ($order->order_status_id == config('orderstatus.delivered')
            || $order->order_status_id == config('orderstatus.cancelled')) {
            return redirect()->route('orders.index')->with('error', __('error update status'));
        }
        $statuses = $this->orderStatusRepo->getAll();

        return view('admins.orders.edit', compact('order', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $order = $this->orderRepo->find($id);
        if ($request->order_status_id == config('orderstatus.cancelled')) {
            foreach ($this->orderRepo->relation($order->id) as $product) {
                $product->quantity += $this->productRepo->getQuantity($product);
                $this->productRepo->update($product->id, ['quantity' => $product->quantity]);
            }
        }
        $this->orderRepo->update($id, $request->only('order_status_id'));

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
