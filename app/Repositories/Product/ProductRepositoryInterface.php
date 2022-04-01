<?php
namespace App\Repositories\Product;

use App\Repositories\RepositoryInterface;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function getQuantity($product);

    public function getAll();
    
    public function getAllWithSearch();
}
