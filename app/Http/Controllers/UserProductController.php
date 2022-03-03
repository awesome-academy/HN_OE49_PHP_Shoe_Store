<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;

class UserProductController extends Controller
{
    public function showByRating(Request $request)
    {
        $products = Product::query();
        if ($request->name) {
            $products = $products->where('name', 'like', '%' . $request->name . '%');
        }
        $products = $products->paginate(config('paginate.pagination'));
        $brands = Brand::all();

        return view('users.shop')->with(compact('products', 'brands'));
    }

    public function showDetails($id)
    {
        $product = Product::findorfail($id);
        $brands = Brand::all();
        $images = Image::where('product_id', $product->id)->get();

        return view('users.show')->with(compact('product', 'images', 'brands'));
    }

    public function showByBrand(Request $request, $id)
    {
        $brand = Brand::findorfail($id);
        $products = Product::query();
        if ($request->name) {
            $products = $products->where('name', 'like', '%' . $request->name . '%');
        }
        $products = $products->where('brand_id', $id)->paginate(config('paginate.pagination'));
        $brands = Brand::all();

        return view('users.showByBrand', compact('brand', 'products', 'brands'));
    }
}
