<?php

namespace Tests\Unit\Commands;

use App\Console\Commands\StatisticCommand;
use App\Mail\MailStatistic;
use App\Models\Order;
use App\Models\User;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use Mockery;
use Tests\TestCase;

class StatisticCommandTest extends TestCase
{
    protected $mockOrder;
    protected $mockUser;
    protected $command;

    public function setUp(): void
    {
        parent::setUp();
        $this->mockOrder = Mockery::mock(OrderRepositoryInterface::class);
        $this->mockUser = Mockery::mock(UserRepositoryInterface::class);
        $this->command = new StatisticCommand($this->mockOrder, $this->mockUser);
    }

    public function tearDown(): void
    {
        Mockery::close();
        unset($this->command);
        parent::tearDown();
    }

    public function testSendMail()
    {
        $data = new Order([
            'id' => 1,
            'total_price' => 1,
        ]);
        $data->created_at = '2022-04-05 14:22:32';
        $data->updated_at = '2022-04-05 14:22:32';
        $user = User::factory()->make(['role_id' => config('auth.roles.admin')]);
        $users = collect();
        $datas = collect();
        $datas->push($data);
        $users->push($user);
        $this->mockOrder->shouldReceive('getOrderDelivered')->andReturn($datas);
        $this->mockUser->shouldReceive('findAdmin')->andReturn($users);
        Mail::fake();
        $this->command->handle();
        Mail::assertSent(MailStatistic::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }
}
