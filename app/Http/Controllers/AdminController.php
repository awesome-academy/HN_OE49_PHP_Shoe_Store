<?php

namespace App\Http\Controllers;

use App\Repositories\Product\ProductRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function index()
    {
        $totalByToday = $this->productRepo->getProductSold('day');
        $totalByWeek = $this->productRepo->getProductSold('week');
        $totalByMonth = $this->productRepo->getProductSold('month');

        foreach ($totalByToday as $product) {
            $brands['today'][$product->brand->name] = $this->productRepo->getSumQuantity($product);
        }

        foreach ($totalByWeek as $product) {
            $brands['week'][$product->brand->name] = $this->productRepo->getSumQuantity($product);
        }

        foreach ($totalByMonth as $product) {
            $brands['month'][$product->brand->name] = $this->productRepo->getSumQuantity($product);
        }

        return view('admins.dashboard')->with([
            'label' => array_keys($brands['today']),
            'quantity1' => array_values($brands['today']),
            'quantity2' => array_values($brands['week']),
            'quantity3' => array_values($brands['month'])
        ]);
    }
}
