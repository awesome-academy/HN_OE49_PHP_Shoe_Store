<?php

namespace Tests\Unit\Models;

use App\Models\OrderStatus;
use App\Models\Order;
use Tests\ModelTestCase;

class OrderStatusTest extends ModelTestCase
{
    public function testOrdersRelation()
    {
        $orderstatus = new OrderStatus();

        $this->assertHasManyRelation($orderstatus->orders(), $orderstatus, new Order());
    }
}
