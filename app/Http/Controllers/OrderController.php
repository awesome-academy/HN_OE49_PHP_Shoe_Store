<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
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
            
            $order_product = [];
            foreach ($cart as $key => $value) {
                $prd = Product::find($key);
                if ($prd['quantity'] >= $value['quantity']) {
                    $prd->decrement('quantity', $value['quantity']);
                } else {
                    return redirect()->route('cart')
                        ->with('error', __('not enough', ['attr' => $prd['name'], 'qtt' => $prd['quantity']]));
                }
            }
            $orders = Order::create([
                'user_id' => Auth::user()->id,
                'total_price' => $request->total_price,
                'order_status_id' => $order_status,
            ]);
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

    public function historyOrder()
    {
        $brands = Brand::all();
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        return view('users.history.index')->with(compact('brands', 'orders'));
    }

    public function showOrderDetail($id)
    {
        $brands = Brand::all();
        $shipping = 0;
        $total_price = 0;
        $orders = Order::where('user_id', Auth::user()->id)->with('products', 'orderStatus')->findOrFail($id);
        foreach ($orders->products as $product) {
            $total_price += $product->price * $product->pivot->quantity;
        }

        return view('users.history.show')->with(compact('brands', 'orders', 'shipping', 'total_price'));
    }
}
