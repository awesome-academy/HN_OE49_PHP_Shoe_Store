<?php

namespace Tests\Unit\Notification;

use App\Models\User;
use App\Notifications\OrderNotification;
use Tests\TestCase;

class OrderNotificationTest extends TestCase
{
    protected $notification;
    protected $data;

    public function setUp(): void
    {
        parent::setUp();
        $this->data = [];
        $this->notification = new OrderNotification($this->data);
    }

    public function tearDown(): void
    {
        unset($this->data);
        unset($this->notification);
        parent::tearDown();
    }

    public function testVia()
    {
        $this->assertEquals(['database'], $this->notification->via(User::class));
    }

    public function testToArray()
    {
        $this->assertEquals($this->data, $this->notification->toArray(User::class));
    }
}
