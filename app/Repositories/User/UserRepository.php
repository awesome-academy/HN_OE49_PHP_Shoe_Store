<?php
namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return User::class;
    }

    public function getAllUser()
    {
        return $this->model::orderby('name', 'ASC')
            ->paginate(config('paginate.pagination'));
    }

    public function getUserByOrderDelivered($id)
    {
        return $this->model::with(['orders' => function ($query) {
            $query->where('order_status_id', config('orderstatus.delivered'));
        }])->where('id', $id)->first();
    }

    public function findAdmin()
    {
        return $this->model->where('role_id', config('auth.roles.admin'))->get();
    }
}
