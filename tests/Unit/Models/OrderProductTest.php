<?php

namespace Tests\Unit\Models;

use App\Models\OrderProduct;
use Tests\ModelTestCase;

class OrderProductTest extends ModelTestCase
{
    public function testModelConfiguration()
    {
        $this->runConfigurationAssertions(new OrderProduct(), [
            'fillable' => [
                'order_id',
                'product_id',
                'quantity',
            ],
        ]);
    }
}
