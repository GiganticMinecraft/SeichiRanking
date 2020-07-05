<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CountRanking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ranking:count {type=daily : 期間を指定}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Web整地ランキングのカウント用バッチ';

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
     */
    public function handle()
    {
        $type = $this->argument('type');

        switch ($type) {
            case 'daily':
                (new CountDailyRanking())->handle();
                break;
            case 'weekly':
                (new CountWeeklyRanking())->handle();
                break;
            case 'monthly':
                (new CountMonthlyRanking())->handle();
                break;
            //case 'yearly':
            //  break;
            default:
        }
    }
}
