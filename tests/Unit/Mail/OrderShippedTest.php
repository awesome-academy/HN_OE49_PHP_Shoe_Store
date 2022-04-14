<?php

namespace Tests\Unit\Mail;

use App\Mail\OrderShipped;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OrderShippedTest extends TestCase
{
    protected $order;
    protected $user;
    protected $cart;
    protected $mail;

    public function setUp(): void
    {
        parent::setUp();

        $this->order = Order::factory()->make(['id' => 100]);
        $this->cart = [];
        $this->user = User::factory()->make();
        $this->mail = new OrderShipped($this->order, $this->cart, $this->user);
    }

    public function tearDown(): void
    {
        unset($this->order);
        unset($this->user);
        unset($this->cart);
        unset($this->mail);

        parent::tearDown();
    }

    public function testBuildSendMailMarkdown()
    {
        Mail::fake();
        Mail::send($this->mail);
        Mail::assertSent(OrderShipped::class, function ($mail) {
            $mail->build();
            $this->assertEquals($mail->viewData['user'], $this->user);
            $this->assertEquals($mail->viewData['url'], route('user.history.detail', $this->order->id));
            $this->assertEquals($mail->viewData['cart'], $this->cart);

            return true;
        });
    }
}
