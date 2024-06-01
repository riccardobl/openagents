<?php

namespace App\Console\Commands;

use App\Services\PaymentService;
use Illuminate\Console\Command;

class SweepAgentBalancesToUsers extends Command
{
    protected $signature = 'sweep';

    protected $description = 'Sweep agent balances to users';

    public function handle()
    {
        $payService = new PaymentService();
        $payService->sweepAllAgentBalances();
    }
}
