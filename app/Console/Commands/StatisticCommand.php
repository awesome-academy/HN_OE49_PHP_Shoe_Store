<?php

namespace App\Console\Commands;

use App\Mail\MailStatistic;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StatisticCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:statistic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send to new statistic';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(
        OrderRepositoryInterface $orderRepo,
        UserRepositoryInterface $userRepo
    ) {
        $datas = $orderRepo->getOrderDelivered();
        $users = $userRepo->findAdmin();
        foreach ($users as $user) {
            Mail::to($user['email'])->send(new MailStatistic($datas));
        }
        $this->info('Successfully sent email to admin');
    }
}
