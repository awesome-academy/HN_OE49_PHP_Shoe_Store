<?php
namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Order::class;
    }

    public function getOrder()
    {
        return $this->model->with('user', 'products', 'orderStatus')
            ->orderBy('order_status_id')
            ->orderBy('created_at', 'DESC')
            ->paginate(config('paginate.pagination'));
    }

    public function relation($id)
    {
        $order = $this->find($id);
        
        return $order->products;
    }
}
