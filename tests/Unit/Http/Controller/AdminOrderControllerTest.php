<?php

namespace Tests\Unit\Http\Controller;

use App\Http\Controllers\AdminOrderController;
use App\Http\Requests\Orders\UpdateRequest;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderStatus\OrderStatusRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Mockery;
use Tests\TestCase;

class AdminOrderControllerTest extends TestCase
{
    protected $mockOrderRepo;
    protected $mockOrderStatusRepo;
    protected $mockProductRepo;
    protected $mockUserRepo;
    protected $controller;
    protected $updateRequest;
    protected $order;

    public function setUp() : void
    {
        parent::setUp();
        $this->afterApplicationCreated(function () {
            $this->mockOrderRepo = Mockery::mock($this->app->make(OrderRepositoryInterface::class));
            $this->mockOrderStatusRepo = Mockery::mock($this->app->make(OrderStatusRepositoryInterface::class));
            $this->mockProductRepo = Mockery::mock($this->app->make(ProductRepositoryInterface::class));
            $this->mockUserRepo = Mockery::mock($this->app->make(UserRepositoryInterface::class));
        });
        $this->order = Order::factory()->make();
        $this->order->id = 1;
        $this->updateRequest = new UpdateRequest();
        $this->controller = new AdminOrderController(
            $this->mockOrderRepo,
            $this->mockOrderStatusRepo,
            $this->mockProductRepo,
            $this->mockUserRepo
        );
    }

    public function tearDown() : void
    {
        Mockery::close();
        unset($this->controller);
        unset($this->updateRequest);
        parent::tearDown();
    }

    public function testIndexReturnView()
    {
        $this->mockOrderRepo->shouldReceive('getOrder');
        
        $view = $this->controller->index();

        $this->assertEquals('admins.orders.index', $view->getName());
        $this->assertArrayHasKey('orders', $view->getData());
    }

    public function testShowReturnView()
    {
        $this->mockOrderRepo->shouldReceive('find');
        $view = $this->controller->show(1);

        $this->assertEquals('admins.orders.detail', $view->getName());
        $this->assertArrayHasKey('order', $view->getData());
    }

    public function testCannotEditOrder()
    {
        $order = $this->order;
        $order->order_status_id = config('orderstatus.cancelled');
        $this->mockOrderRepo->shouldReceive('find')->once()->andReturn($order);
        $redirect = $this->controller->edit($order->id);
        
        $this->assertInstanceOf(RedirectResponse::class, $redirect);
        $this->assertArrayHasKey('error', $redirect->getSession()->all());
    }

    public function testEditReturnView()
    {
        $order = $this->order;
        $order->order_status_id = config('orderstatus.waiting');
        $this->mockOrderRepo->shouldReceive('find')->once()->andReturn($order);
        $this->mockOrderStatusRepo->shouldReceive('getAll')->once();
        
        $view = $this->controller->edit($order->id);
        
        $this->assertEquals('admins.orders.edit', $view->getName());
        $this->assertArrayHasKey('order', $view->getData());
        $this->assertArrayHasKey('statuses', $view->getData());
    }

    // public function testUpdateStatusCancelOrder()
    // {
    //     $order = $this->order;
    //     $products = Product::factory(5)->make([
    //         'id' => 1,
    //     ]);
    //     $this->mockOrderRepo->shouldReceive('find')->andReturn($order);
    //     $request = $this->updateRequest;
    //     $request->request->add(['order_status_id' => config('orderstatus.cancelled')]);
    //     $request->setMethod('PUT');
    
    //     $this->mockOrderRepo->shouldReceive('update')->once()->andReturn(true);
    //     $this->mockOrderRepo->shouldReceive('relation')->once()->andReturn($products);
    //     $this->mockProductRepo->shouldReceive('getQuantity')->andReturn(1);
    //     $this->mockProductRepo->shouldReceive('update')->andReturn(true);

    //     $redirect = $this->controller->update($request, $order->id);

    //     $this->assertInstanceOf(RedirectResponse::class, $redirect);
    //     $this->assertArrayHasKey('message', $redirect->getSession()->all());
    // }

    // public function testUpdateOtherStatusOrder()
    // {
    //     $order = $this->order;
    //     $this->mockOrderRepo->shouldReceive('find')->once()->andReturn($order);
    //     $request = $this->updateRequest;
    //     $request->request->add(['order_status_id' => config('orderstatus.preparing')]);
    //     $request->setMethod('PUT');
        
    //     $this->mockOrderRepo->shouldReceive('update')->once()->andReturn(true);
    //     $redirect = $this->controller->update($request, $order->id);

    //     $this->assertInstanceOf(RedirectResponse::class, $redirect);
    //     $this->assertArrayHasKey('message', $redirect->getSession()->all());
    // }
}
