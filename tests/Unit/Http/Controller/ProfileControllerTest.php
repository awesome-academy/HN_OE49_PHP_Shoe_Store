<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\ProfileController;
use App\Http\Requests\Profile\UpdateRequest;
use App\Models\User;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Mockery;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    
    protected $controller;
    protected $profileMock;
    protected $brandMock;
    protected $user;

    public function setUp() : void
    {
        parent::setUp();
        $this->user = User::factory()->make();
        $this->profileMock = Mockery::mock(UserRepositoryInterface::class);
        $this->brandMock = Mockery::mock(BrandRepositoryInterface::class);
        $this->controller = new ProfileController($this->profileMock, $this->brandMock);
    }

    public function tearDown() : void
    {
        // Other tearing down ...
        Mockery::close();
        unset($this->controller);
        unset($this->user);
        parent::tearDown();
    }

    public function testShowProfileReturnView()
    {
        $this->brandMock->shouldReceive('getAll');
        $this->profileMock->shouldReceive('find')->once()->andReturn($this->user);

        $view = $this->controller->show(1);

        $this->assertEquals('users.profile.show', $view->getName());
        $this->assertArrayHasKey('brands', $view->getData());
        $this->assertArrayHasKey('user', $view->getData());
    }

    public function testEditProfileReturnView()
    {
        $this->brandMock->shouldReceive('getAll');
        $this->profileMock->shouldReceive('find')->once()->andReturn($this->user);

        $view = $this->controller->edit(1);

        $this->assertEquals('users.profile.edit', $view->getName());
        $this->assertArrayHasKey('brands', $view->getData());
        $this->assertArrayHasKey('user', $view->getData());
    }

    public function testUploadAvatar()
    {
        $data = [
            'avatar' => UploadedFile::fake()->image('user-icon.png')
        ];
        $request = new UpdateRequest($data);
        $this->profileMock->shouldReceive('find')->once()->andReturn($this->user);
        $this->profileMock->shouldReceive('update')->once()->andReturn(true);
        $reponse = $this->controller->update($request, 1);
        $this->assertInstanceOf(RedirectResponse::class, $reponse);
    }

    public function testUpdateSuccess()
    {
        $avatar = UploadedFile::fake()->image('user-icon.png');
        $this->profileMock->shouldReceive('find')->once()->andReturn($this->user);
        $this->profileMock->shouldReceive('update')->once()->andReturn(true);
        $data = [
            'name' => $this->user->name,
            'address'=> $this->user->address,
            'phone' => $this->user->phone,
            'email' => $this->user->email,
            'avatar' => $avatar,
        ];
        $request = new UpdateRequest($data);
        $reponse = $this->controller->update($request, 1);

        $this->assertInstanceOf(RedirectResponse::class, $reponse);
        $this->assertEquals(302, $reponse->status());
        $this->assertArrayHasKey('success', $reponse->getSession()->all());
    }
}
