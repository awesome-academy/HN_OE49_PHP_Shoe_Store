<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProductController extends Controller
{
    public function showByRating(Request $request)
    {
        $products = Product::withAvg('comments', 'rating')
            ->orderBy('comments_avg_rating', 'desc');
        $products = $products->paginate(config('paginate.pagination'));
        $brands = Brand::all();

        return view('users.shop')->with(compact('products', 'brands'));
    }

    public function showDetails($id)
    {
        $product_sold = 0;
        $brands = Brand::all();
        $comments = Comment::all();
        $allowComment = false;

        $product = Product::with(['orders' => function ($query) {
            $query->where('order_status_id', config('orderstatus.delivered'));
        }])->findorfail($id);
        
        foreach ($product->orders as $order) {
            $product_sold += $order->pivot->quantity;
        }
        
        $images = Image::where('product_id', $product->id)->get();
        

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
        return view('users.show')->with(compact('product', 'images', 'brands', 'allowComment', 'product_sold'));
    }

    public function showByBrand(Request $request, $id)
    {
        $brand = Brand::findorfail($id);
        $products = Product::query();
        $products = $products->where('brand_id', $id)->paginate(config('paginate.pagination'));
        $brands = Brand::all();

        return view('users.showByBrand', compact('brand', 'products', 'brands'));
    }
}
