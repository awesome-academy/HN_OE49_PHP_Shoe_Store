<?php

namespace Tests\Unit\Models;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use Tests\ModelTestCase;

class OrderTest extends ModelTestCase
{
    protected $order;

    public function setUp() : void
    {
        parent::setUp();
        $this->order = new Order();
    }

    public function tearDown() : void
    {
        unset($this->order);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->runConfigurationAssertions($this->order, [
            'fillable' => ['id', 'user_id', 'total_price', 'order_status_id'],
            'table' => 'orders',
        ]);
    }

    public function testUserRelation()
    {
        $this->assertBelongsToRelation($this->order->user(), $this->order, new User(), 'user_id', 'id');
    }

    public function testOrderStatusRelation()
    {
        $this->assertBelongsToRelation(
            $this->order->orderStatus(),
            $this->order,
            new OrderStatus(),
            'order_status_id',
            'id'
        );
    }

    public function testProductsRelation()
    {
        $this->assertBelongsToManyRelation(
            $this->order->products(),
            $this->order,
            new Product(),
            'order_products.order_id',
            'order_products.product_id'
        );
    }
}
