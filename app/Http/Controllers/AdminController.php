<?php

namespace App\Http\Controllers;

use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function index(Request $request)
    {
        $sub = 'day';
        if ($request->all()) {
            $sub = $request->filter;
        }
        $products = $this->productRepo->getProductSold($sub);
        $brands_temp = [];
        foreach ($products as $product) {
            $brands_temp[$product->brand->name] = 0;
            foreach ($this->productRepo->relation($product) as $product_order) {
                if (array_key_exists($product->brand->name, $brands_temp)) {
                    $brands_temp[$product->brand->name] += $this->productRepo->getQuantity($product_order);
                } else {
                    $brands_temp[$product->brand->name] = $this->productRepo->getQuantity($product_order);
                }
            }
        }
        return view('admins.dashboard')->with([
            'label' => array_keys($brands_temp),
            'quantity' => array_values($brands_temp)
        ]);
    }
}
