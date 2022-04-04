<?php

namespace App\Http\Controllers;

use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;

class OrderController extends Controller
{
    protected $productRepo;
    protected $brandRepo;
    protected $orderRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        BrandRepositoryInterface $brandRepo,
        OrderRepositoryInterface $orderRepo
    ) {
        $this->productRepo = $productRepo;
        $this->brandRepo = $brandRepo;
        $this->orderRepo = $orderRepo;
    }

    public function infoOrder()
    {
        $cart = [];
        $shipping = 0;
        $brands = $this->brandRepo->getAll();
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
                $prd = $this->productRepo->find($key);
                if ($prd['quantity'] >= $value['quantity']) {
                    $prd->decrement('quantity', $value['quantity']);
                    $total_price += $value['quantity'] * $value['price'];
                } else {
                    return redirect()->route('cart')
                        ->with('error', __('not enough', ['attr' => $prd['name'], 'qtt' => $prd['quantity']]));
                }
            }
            $orders = $this->orderRepo->create([
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
        $brands = $this->brandRepo->getAll();
        $orders = $this->orderRepo->getHistoryOrder(Auth::user()->id);

        return view('users.history.index')->with(compact('brands', 'orders'));
    }

    public function showOrderDetail($id)
    {
        $brands = $this->brandRepo->getAll();
        $shipping = 0;
        $total_price = 0;
        $order = $this->orderRepo->getOrderDetail(Auth::user()->id, $id);
        foreach ($this->orderRepo->relation($order->id) as $product) {
            $total_price += $product->price * $this->productRepo->getQuantity($product);
        }

        return view('users.history.show')->with(compact('brands', 'order', 'shipping', 'total_price'));
    }
    
    public function updatestatus($id)
    {
        $order = $this->orderRepo->find($id);
        $status = request()->order_status_id;
        if ($status == config('orderstatus.waiting') || $status == config('orderstatus.preparing')) {
            $order->order_status_id = config('orderstatus.cancelled');
            foreach ($this->orderRepo->relation($id) as $product) {
                $product->quantity += $this->productRepo->getQuantity($product);
                $product->update();
            }
            $order->update();
    
            return redirect()->route('user.history')->with('success', __('success order cancel'));
        } elseif ($status == config('orderstatus.cancelled')) {
            foreach ($this->orderRepo->relation($id) as $productOrder) {
                $product = $this->productRepo->find($productOrder['id']);
                if ($product['quantity'] >= $this->productRepo->getQuantity($productOrder)) {
                    $product->decrement('quantity', $this->productRepo->getQuantity($productOrder));
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
