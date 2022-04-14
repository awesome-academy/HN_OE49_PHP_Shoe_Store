<?php
namespace App\Repositories\Order;

use App\Repositories\RepositoryInterface;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getOrder();
    public function relation($id);
    public function getQuantity($order);
    public function getHistoryOrder($user_id);
    public function getOrderDetail($user_id, $order_id);
    public function getOrderDelivered();
}
