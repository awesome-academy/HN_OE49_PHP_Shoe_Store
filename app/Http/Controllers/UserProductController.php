<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;

class UserProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $brands = Brand::all();

        return view('users.shop')->with(compact('products', 'brands'));
    }

    public function showByRating($id)
    {
        $product = Product::findorfail($id);
        $brands = Brand::all();
        $images = Image::where('product_id', $product->id)->get();

        return view('users.show')->with(compact('product', 'images', 'brands'));
    }
}
