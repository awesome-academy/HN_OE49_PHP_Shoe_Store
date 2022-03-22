<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Tests\ModelTestCase;

class CommentTest extends ModelTestCase
{
    protected $comment;

    public function setUp() : void
    {
        parent::setUp();
        $this->comment = new Comment();
    }

    public function tearDown() : void
    {
        unset($this->comment);
        parent::tearDown();
    }

    public function testModelConfiguration()
    {
        $this->runConfigurationAssertions(new Comment(), [
            'fillable' => [
                'content',
                'user_id',
                'rating',
                'product_id',
            ],
            'table' => "comments",
        ]);
    }

    public function testUserRelation()
    {
        $this->assertBelongsToRelation($this->comment->user(), $this->comment, new User(), 'user_id', 'id');
    }

    public function testProductRelation()
    {
        $this->assertBelongsToRelation(
            $this->comment->product(),
            $this->comment,
            new Product(),
            'product_id',
            'id'
        );
    }
}
