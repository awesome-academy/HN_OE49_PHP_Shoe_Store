<?php

namespace Tests\Unit\Models;

use App\Models\Brand;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use Tests\ModelTestCase;

class ProductTest extends ModelTestCase
{
    protected $product;

    public function setUp() : void
    {
        parent::setUp();
        $this->product = new Product();
    }

    public function tearDown() : void
    {
        unset($this->product);
        parent::tearDown();
    }

    public function testProductConfiguration()
    {
        $this->runConfigurationAssertions(new Product(), [
            'fillable' => [
                'name',
                'price',
                'quantity',
                'brand_id',
                'desc',
            ],
        ]);
    }

    public function testBrandRelation()
    {
        $this->assertBelongsToRelation($this->product->brand(), $this->product, new Brand(), 'brand_id', 'id');
    }

    public function testImagesRelation()
    {
        $this->assertHasManyRelation($this->product->images(), $this->product, new Image());
    }

    public function testOrdersRelation()
    {
        $this->assertBelongsToManyRelation(
            $this->product->orders(),
            $this->product,
            new Order(),
            'order_products.product_id',
            'order_products.order_id'
        );
    }

    public function testCommentsRelation()
    {
        $this->assertHasManyRelation($this->product->comments(), $this->product, new Comment());
    }

    public function testAppendRating()
    {
        $product = Product::factory()->make(['id' => 30]);
        $comments = collect();
        for ($i= 1; $i <=3; $i++) {
            $comment = Comment::factory()->make([
                'user_id' => $i,
                'product_id' => $product->id,
                'rating' => rand(1, 5),
            ]);
            $comments->push($comment);
        }
        $product->setRelation('comments', $comments);
        $this->assertEquals($comments->avg('rating'), $product->avg_rating);
    }
}
