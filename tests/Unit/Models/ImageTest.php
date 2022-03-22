<?php

namespace Tests\Unit\Models;

use App\Models\Image;
use App\Models\Product;
use Tests\ModelTestCase;

class ImageTest extends ModelTestCase
{
    protected $image;

    public function setUp() : void
    {
        parent::setUp();
        $this->image = new Image();
    }

    public function tearDown() : void
    {
        unset($this->image);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->runConfigurationAssertions($this->image, [
            'fillable' => [
                'product_id',
                'name',
            ],
            'table' => "images",
        ]);
    }

    public function testProductRelation()
    {
        $this->assertBelongsToRelation(
            $this->image->product(),
            $this->image,
            new Product(),
            'product_id',
            'id'
        );
    }
}
