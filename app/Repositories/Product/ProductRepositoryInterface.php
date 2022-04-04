<?php
namespace App\Repositories\Product;

use App\Repositories\RepositoryInterface;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function getQuantity($product);
    public function getAll();
    public function getAllWithSearch();
    public function relation($product);
    public function searchProduct($name, $brand_id);
    public function getProductByAvgRating();
    public function getProductByOrderDelivered($id);
}
