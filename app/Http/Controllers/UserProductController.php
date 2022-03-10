<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserProductController extends Controller
{
    public function showByRating(Request $request)
    {
        $products = Product::with('comments')
                        ->join('comments', 'products.id', '=', 'comments.product_id')
                        ->select('products.*', DB::raw('avg(comments.rating) as rating'))
                        ->groupBy('products.id')
                        ->orderBy('rating', 'desc');
        if ($request->name) {
            $products = $products->where('name', 'like', '%' . $request->name . '%');
        }
        $products = $products->paginate(config('paginate.pagination'));
        $brands = Brand::all();

        return view('users.shop')->with(compact('products', 'brands'));
    }

    public function getAll(Request $request)
    {
        $products = Product::orderBy('name', 'desc');
        if ($request->name) {
            $products = $products->where('name', 'like', '%' . $request->name . '%');
        }
        $products = $products->paginate(config('paginate.pagination'));
        $brands = Brand::all();

        return view('users.all')->with(compact('products', 'brands'));
    }

    public function showDetails($id)
    {
        $product = Product::findorfail($id);
        $brands = Brand::all();
        $comments = Comment::all();
        // dd($comments);
        $images = Image::where('product_id', $product->id)->get();
        $allowComment = false;

        $user = User::with(['orders' => function ($query) {
            $query->where('order_status_id', config('orderstatus.delivered'));
        }])->where('id', Auth::user()->id)->first();
        
        foreach ($user->orders as $order) {
            foreach ($order->products as $p) {
                if ($p->id == $id) {
                    $allowComment = true;
                    foreach ($comments as $comment) {
                        if ($comment['product_id'] == $id && $comment['user_id'] == Auth::user()->id) {
                            $allowComment = false;
                            break;
                        }
                    }
                }
            }
        }
        return view('users.show')->with(compact('product', 'images', 'brands', 'allowComment'));
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
