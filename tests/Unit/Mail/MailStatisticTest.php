<?php

namespace Tests\Unit\Mail;

use App\Mail\MailStatistic;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MailStatisticTest extends TestCase
{
    protected $datas;
    protected $mail;

    public function setUp(): void
    {
        parent::setUp();

        $this->datas = Order::factory(2)->make([
            'id' => 100,
            'order_status_id' => 4,
            'total_price' => rand(100000, 1000000),
            'updated_at' => Carbon::now()->toDateTimeString(),

        ]);
        $this->mail = new MailStatistic($this->datas);
    }

    public function tearDown(): void
    {
        unset($this->datas);
        unset($this->mail);

        parent::tearDown();
    }

    public function testBuildSendMailMarkdown()
    {
        $fromDate = Carbon::now('Asia/Ho_Chi_Minh')->subWeek()->startOfWeek(Carbon::SUNDAY);
        $toDate = Carbon::now('Asia/Ho_Chi_Minh')->subWeek()->endOfWeek(Carbon::SATURDAY);
        Mail::fake();
        Mail::send($this->mail);
        Mail::assertSent(MailStatistic::class, function ($mail) use ($fromDate, $toDate) {
            $mail->build();
            $this->assertEquals($mail->viewData['datas'], $this->datas);
            $this->assertEquals($mail->viewData['fromDate'], $fromDate);
            $this->assertEquals($mail->viewData['toDate'], $toDate);

            return true;
        });
    }
}
