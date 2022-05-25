<?php

namespace Tests\Unit;

use App\Http\Controllers\AdminController;
use App\Models\Brand;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use Carbon\Carbon;
use Mockery;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    protected $mockProductRepo;
    protected $controller;
    protected $products;
    protected $brand;
    protected $order;

    public function setUp() :void
    {
        parent::setUp();
        $this->afterApplicationCreated(function () {
            $this->mockProductRepo = Mockery::mock($this->app->make(ProductRepositoryInterface::class));
        });
        $this->controller = new AdminController($this->mockProductRepo);
        $this->brand = Brand::factory()->make();
        $this->products = Product::factory(2)->make([
            'id' => rand(50, 100),
        ]);
        foreach ($this->products as $product) {
            $product->setRelations(['brand' => $this->brand]);
        }
    }

    public function tearDown() :void
    {
        Mockery::close();
        unset($this->controller);
        parent::tearDown();
    }

    public function testIndexReturnView()
    {
        $this->mockProductRepo->shouldReceive('getProductSold')->andReturn($this->products);
        foreach ($this->products as $product) {
            $this->mockProductRepo->shouldReceive('getSumQuantity')->with($product)->andReturn(1);
        }
        
        $view = $this->controller->index();
        $this->assertEquals('admins.dashboard', $view->getName());
        $this->assertArrayHasKey('label', $view->getData());
        $this->assertArrayHasKey('quantity_day', $view->getData());
        $this->assertArrayHasKey('quantity_week', $view->getData());
        $this->assertArrayHasKey('quantity_month', $view->getData());
    }
}
