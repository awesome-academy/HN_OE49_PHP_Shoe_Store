<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailStatistic extends Mailable
{
    use Queueable, SerializesModels;

    protected $datas;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datas)
    {
        $this->datas = $datas;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fromDate = Carbon::now('Asia/Ho_Chi_Minh')->subWeek()->startOfWeek(Carbon::SUNDAY);
        $toDate = Carbon::now('Asia/Ho_Chi_Minh')->subWeek()->endOfWeek(Carbon::SATURDAY);
        return $this->markdown('emails.statistic')->with([
            'datas' => $this->datas,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
        ]);
    }
}
