<?php
namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Product::class;
    }

    public function getQuantity($product)
    {
        return $product->pivot->quantity;
    }

    public function getAllWithSearch()
    {
        $products = $this->model->orderBy('created_at', 'DESC');
        if (request()->name) {
            $products = $products->where('name', 'like', '%' . request()->name . '%');
        }
        if (request()->min_price && is_numeric(request()->min_price)) {
            $products = $products->where('price', '>', request()->min_price);
        }
        if (request()->max_price && is_numeric(request()->max_price)) {
            $products = $products->where('price', '<', request()->max_price);
        }
        return $products->paginate(config('paginate.pagination'));
    }
}
