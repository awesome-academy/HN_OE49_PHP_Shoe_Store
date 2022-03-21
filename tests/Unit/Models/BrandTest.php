<?php

namespace Tests\Unit\Models;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Tests\ModelTestCase;

class BrandTest extends ModelTestCase
{
    protected $brand;

    public function setUp() : void
    {
        parent::setUp();
        $this->brand = new Brand();
    }

    public function tearDown() : void
    {
        unset($this->brand);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->runConfigurationAssertions($this->brand, [
            'fillable' => ['name', 'desc'],
            'table' => 'brands',
        ]);
    }

    public function testProductsRelation()
    {
        $this->assertHasManyRelation($this->brand->products(), $this->brand, new Product());
    }
}
