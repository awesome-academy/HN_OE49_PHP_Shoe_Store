<?php
namespace App\Repositories\OrderProduct;

use App\Models\OrderProduct;
use App\Repositories\BaseRepository;

class OrderProductRepository extends BaseRepository implements OrderProductRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return OrderProduct::class;
    }
}
