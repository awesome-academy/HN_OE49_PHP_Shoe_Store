<?php
namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getAllUser();
    public function getUserByOrderDelivered($id);
    public function findAdmin();
    public function notify($user, $data);
}
