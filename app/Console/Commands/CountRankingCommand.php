<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CountRankingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ranking:count {type=all : カウントするランキング}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Web整地ランキングの用バッチ';

    private $rankings;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->rankings = [
            "daily" => new CountDailyRanking(),
            "weekly" => new CountWeeklyRanking(),
            "monthly" => new CountMonthlyRanking(),
            "yearly" => new CountYearlyRanking()
        ];
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $type = $this->argument('type');
        switch ($type){
            case "all":
                foreach ($this->rankings as $ranking) {
                    $ranking->handle();
                }
                break;
            default:
                $this->rankings[$type]->handle();
        }
    }
}
