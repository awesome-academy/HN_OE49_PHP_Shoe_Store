<?php

namespace App\Http\Controllers;

use App\Helper\CartHelper;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        $product = new Product();

        return view('users.cart', compact('brands', 'product'));
    }

    public function add(CartHelper $cart, $id)
    {
        $product = Product::find($id);
        $cart->add($product);

        return redirect()->back();
    }

    public function remove(CartHelper $cart, $id)
    {
        $cart->remove($id);

        return redirect()->back();
    }

    public function update(CartHelper $cart, $id)
    {
        $quantity = request()->quantity ? request()->quantity : 1;
        $cart->update($id, $quantity);

        return redirect()->back();
    }

    public function clear(CartHelper $cart)
    {
        $cart->clear();

        return redirect()->back();
    }
}
