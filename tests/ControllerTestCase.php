<?php

namespace Tests;

use App\Models\User;
use Illuminate\Http\RedirectResponse;

abstract class ControllerTestCase extends TestCase
{
    protected function testUpdateStatus($order, $request, $status, $mockOrder, $mockUser)
    {
        $user = User::factory()->make();
        $mockOrder->shouldReceive('find')->andReturn($order);
        $request->request->add(['order_status_id' => $status]);
        $request->setMethod('PUT');

        $mockUser->shouldReceive('find')->andReturn($user);
        $mockUser->shouldReceive('notify')->andReturn(true);

        $mockOrder->shouldReceive('update')->andReturn(true);

        $redirect = $this->controller->update($request, $order->id);
        $this->testAssert($redirect, 'message');
    }

    protected function testAssert($redirect, $key)
    {
        $this->assertInstanceOf(RedirectResponse::class, $redirect);
        $this->assertArrayHasKey($key, $redirect->getSession()->all());
    }
}
