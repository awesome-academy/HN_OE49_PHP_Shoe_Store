<?php

namespace App\Http\Controllers;

use App\Helper\CartHelper;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;

class CartController extends Controller
{
    protected $brandRepo;
    protected $productRepo;

    public function __construct(
        BrandRepositoryInterface $brandRepo,
        ProductRepositoryInterface $productRepo
    ) {
        $this->brandRepo = $brandRepo;
        $this->productRepo = $productRepo;
    }
    
    public function index()
    {
        $brands = $this->brandRepo->getAll();
        $product = $this->productRepo;

        return view('users.cart', compact('brands', 'product'));
    }

    public function add(CartHelper $cart, $id)
    {
        $product = $this->productRepo->find($id);
        $quantity = request()->quantity ? request()->quantity : 1;
        if (is_numeric($quantity)) {
            $cart->add($product, $quantity);

            return redirect()->back();
        } else {
            return redirect()->back()->with('error', __('numeric', ['attr' => __('quantity') ]));
        }
    }

    public function remove(CartHelper $cart, $id)
    {
        $cart->remove($id);

        return redirect()->back();
    }

    public function update(CartHelper $cart, $id)
    {
        $quantity = request()->quantity ? request()->quantity : 1;
        if (is_numeric($quantity)) {
            $cart->update($id, $quantity);

            return redirect()->back();
        } else {
            return redirect()->back()->with('error', __('numeric', ['attr' => __('quantity') ]));
        }
    }
}
