<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $products = Product::orderBy('created_at', 'desc');
        if ($request->name) {
            $products = $products->where('name', 'like', '%' . $request->name . '%');
        }
        $products = $products->paginate(config('paginate.pagination'));
        $brands = Brand::all();

        return view('home')->with(compact('products', 'brands'));
    }
}
