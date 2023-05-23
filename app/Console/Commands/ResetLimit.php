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
        $lbpReseller = LimitPurchase::first()->lbpLimitReseller;
        $usdReseller = LimitPurchase::first()->usdLimitReseller;

        $lbpAgent = LimitPurchase::first()->lbpLimitAgent;
        $usdAgent = LimitPurchase::first()->usdLimitAgent;

        User::query()->where('role', 'Reseller')->update(['limitPurchaseUsd' => $usdReseller]);
        User::query()->where('role', 'Reseller')->update(['limitPurchaseLbp' => $lbpReseller]);

        User::query()->where('role', 'Agent')->update(['topUpUsd' => $usdAgent]);
        User::query()->where('role', 'Agent')->update(['topUpLbp' => $lbpAgent]);

        $this->info('Reset limit updated successfully.');
    }
}
