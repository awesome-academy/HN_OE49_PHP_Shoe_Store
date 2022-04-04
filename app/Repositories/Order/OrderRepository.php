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

    public function getQuantity($order)
    {
        return $order->pivot->quantity;
    }

    public function getHistoryOrder($user_id)
    {
        return $this->model::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getOrderDetail($user_id, $order_id)
    {
        return $this->model::where('user_id', $user_id)
            ->with('products', 'orderStatus')
            ->find($order_id);
    }
}
