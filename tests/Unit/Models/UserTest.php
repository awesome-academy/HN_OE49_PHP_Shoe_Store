<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Tests\ModelTestCase;

class UserTest extends ModelTestCase
{
    protected $user;
    
    public function setUp() : void
    {
        parent::setUp();
        $this->user = new User();
    }

    public function tearDown() : void
    {
        unset($this->user);
        parent::tearDown();
    }

    public function testUserConfiguration()
    {
        $this->runConfigurationAssertions(new User(), [
        'fillable' => [
            'name',
            'avatar',
            'phone',
            'address',
            'email',
            'password',
            'status',
        ],
        'hidden' => [
            'password',
            'remember_token',
            'role_id',
        ],
        'casts' => [
            'id' => 'int',
            'email_verified_at' => 'datetime',
        ]]);
    }

    public function testRoleRelation()
    {
        $this->assertBelongsToRelation($this->user->role(), $this->user, new Role(), 'role_id', 'id');
    }

    public function testOrdersRelation()
    {
        $this->assertHasManyRelation($this->user->orders(), $this->user, new Order(), 'user_id');
    }

    public function testCommentsRelation()
    {
        $this->assertHasManyRelation($this->user->comments(), $this->user, new Comment(), 'user_id');
    }
}
