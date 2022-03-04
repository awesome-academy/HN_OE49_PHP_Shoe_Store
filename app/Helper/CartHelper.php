<?php

namespace App\Helper;

class CartHelper
{
    public $items = [];
    public $total_quantity = 0;
    public $total_price = 0;

    public function __construct()
    {
        $this->items = session('cart') ? session('cart') : [];
        $this->total_quantity = $this->getTotalQuantity();
        $this->total_price = $this->getTotalPrice();
    }

    public function add($product, $quantity = 1)
    {
        $item = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->images->first()->name,
            'quantity' => $quantity,
        ];

        if (isset($this->items[$product->id])) {
            $this->items[$product->id]['quantity'] += $quantity;
        } else {
            $this->items[$product->id] = $item;
        }

        session(['cart' => $this->items]);
    }

    public function remove($id)
    {
        if (isset($this->items[$id])) {
            unset($this->items[$id]);
        }

        session(['cart' => $this->items]);
    }

    public function update($id, $quantity = 1)
    {
        if (isset($this->items[$id])) {
            $this->items[$id]['quantity'] = $quantity;
        }

        session(['cart' => $this->items]);
    }
    
    public function clear()
    {
        session(['cart' => '']);
    }

    private function getTotalPrice()
    {
        $tprice = 0;

        foreach ($this->items as $item) {
            $tprice += $item['price'] * $item['quantity'];
        }

        return $tprice;
    }

    private function getTotalQuantity()
    {
        $tquantity = 0;

        foreach ($this->items as $item) {
            $tquantity += $item['quantity'];
        }
        
        return $tquantity;
    }
}
