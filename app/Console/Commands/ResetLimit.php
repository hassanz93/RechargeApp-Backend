<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\LimitPurchase;

class ResetLimit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resetLimit:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $lbp = LimitPurchase::first()->lbpLimit;
        $usd = LimitPurchase::first()->usdLimit;

        User::query()->update(['limitPurchaseUsd' => $usd]);
        User::query()->update(['limitPurchaseLbp' => $lbp]);
    }
}
