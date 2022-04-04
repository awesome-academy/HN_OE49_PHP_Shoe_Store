<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;

class UserProductController extends Controller
{
    protected $productRepo;
    protected $brandRepo;
    protected $cmtRepo;
    protected $imageRepo;
    protected $userRepo;
    protected $orderRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        BrandRepositoryInterface $brandRepo,
        CommentRepositoryInterface $cmtRepo,
        ImageRepositoryInterface $imageRepo,
        UserRepositoryInterface $userRepo,
        OrderRepositoryInterface $orderRepo
    ) {
        $this->productRepo = $productRepo;
        $this->brandRepo = $brandRepo;
        $this->cmtRepo = $cmtRepo;
        $this->imageRepo = $imageRepo;
        $this->userRepo = $userRepo;
        $this->orderRepo = $orderRepo;
    }

    public function showByRating(Request $request)
    {
        $products = $this->productRepo->getProductByAvgRating();
        $brands = $this->brandRepo->getAll();

        return view('users.shop')->with(compact('products', 'brands'));
    }

    public function showDetails($id)
    {
        $product_sold = 0;
        $brands = $this->brandRepo->getAll();
        $comments = $this->cmtRepo->getAll();
        $allowComment = false;

        $product = $this->productRepo->getProductByOrderDelivered($id);
        foreach ($this->productRepo->relation($product) as $order) {
            $product_sold += $this->orderRepo->getQuantity($order);
        }
        
        $images = $this->imageRepo->getImage($product->id);
        $user = $this->userRepo->getUserByOrderDelivered(Auth::user()->id);
        
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
        $brand = $this->brandRepo->find($id);
        $products = $this->productRepo->getAll()->where('brand_id', $id)->paginate(config('paginate.pagination'));
        $brands = $this->brandRepo->getAll();

        return view('users.showByBrand', compact('brand', 'products', 'brands'));
    }
}
