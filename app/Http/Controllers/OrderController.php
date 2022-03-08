<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function infoOrder()
    {
        $cart = [];
        $shipping = 0;
        $brands = Brand::all();
        if (Session::has('cart')) {
            $cart = session()->get('cart');
            if (count($cart) > 0) {
                return view('users.checkout')->with(compact('cart', 'brands', 'shipping'));
            } else {
                return redirect()->back()->with('error', __('empty_cart'));
            }
        } else {
            return redirect()->back()->with('error', __('empty_cart'));
        }
    }

    public function postOrder(Request $request)
    {
        if (Session::has('cart')) {
            $order_status = config('orderstatus.waiting');
            $cart = session()->get('cart');
            $orders = Order::create([
                'user_id' => Auth::user()->id,
                'total_price' => $request->total_price,
                'order_status_id' => $order_status,
            ]);
            $order_product = [];
            foreach ($cart as $key => $value) {
                $order_product[$key] = [
                    'order_id' => $orders->id,
                    'product_id' => $key,
                    'quantity' => $value['quantity'],
                ];
            }
            OrderProduct::insert($order_product);
            session()->forget('cart');

            return redirect()->route('home')->with('success', __('thanks order'));
        } else {
            return redirect()->back()->with('error', __('empty_cart'));
        }
    }
}
