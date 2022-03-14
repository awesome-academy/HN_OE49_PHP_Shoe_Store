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
            $total_price = 0;
            
            $order_product = [];
            foreach ($cart as $key => $value) {
                $prd = Product::find($key);
                if ($prd['quantity'] >= $value['quantity']) {
                    $prd->decrement('quantity', $value['quantity']);
                    $total_price += $value['quantity'] * $value['price'];
                } else {
                    return redirect()->route('cart')
                        ->with('error', __('not enough', ['attr' => $prd['name'], 'qtt' => $prd['quantity']]));
                }
            }
            $orders = Order::create([
                'user_id' => Auth::user()->id,
                'total_price' => $total_price,
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
        $order = Order::where('user_id', Auth::user()->id)->with('products', 'orderStatus')->findOrFail($id);
        foreach ($order->products as $product) {
            $total_price += $product->price * $product->pivot->quantity;
        }

        return view('users.history.show')->with(compact('brands', 'order', 'shipping', 'total_price'));
    }
    
    public function updatestatus($id)
    {
        $order = Order::findorfail($id);
        $status = request()->order_status_id;
        if ($status == config('orderstatus.waiting') || $status == config('orderstatus.preparing')) {
            $order->order_status_id = config('orderstatus.cancelled');
            foreach ($order->products as $product) {
                $product->quantity += $product->pivot->quantity;
                $product->update();
            }
            $order->update();
    
            return redirect()->route('user.history')->with('success', __('success order cancel'));
        } elseif ($status == config('orderstatus.cancelled')) {
            foreach ($order->products as $productOrder) {
                $product = Product::find($productOrder['id']);
                if ($product['quantity'] >= $productOrder->pivot->quantity) {
                    $product->decrement('quantity', $productOrder->pivot->quantity);
                } else {
                    return redirect()->route('home')
                        ->with('error', __('not enough', ['attr' => $product['name'], 'qtt' => $product['quantity']]));
                }
            }
            $order->update([
                'order_status_id' => config('orderstatus.waiting'),
            ]);

            return redirect()->route('home')->with('success', __('thanks order'));
        } else {
            return redirect()->route('user.history')->with('error', __('fail order cancel'));
        }
    }
}
