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

    public function getAll()
    {
        return $this->model->orderBy('created_at', 'DESC');
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

    public function relation($product)
    {
        return $product->orders;
    }

    public function searchProduct($name, $brand_id)
    {
        $product = $this->model->orderBy('created_at', 'DESC');
        if (!is_null($name)) {
            $product = $product->where('name', 'like', '%' . $name .'%');
        }
        if (!is_null($brand_id)) {
            $product =  $product->where('brand_id', 'like', '%' . $brand_id .'%');
        }
        return $product;
    }

    public function getProductByAvgRating()
    {
        return $this->model->withAvg('comments', 'rating')
            ->orderBy('comments_avg_rating', 'desc')
            ->paginate(config('paginate.pagination'));
    }

    public function getProductByOrderDelivered($id)
    {
        return $this->model->with(['orders' => function ($query) {
            $query->where('order_status_id', config('orderstatus.delivered'));
        }])->findorfail($id);
    }
}
