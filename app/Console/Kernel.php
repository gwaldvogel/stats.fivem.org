<?php

namespace App\Console;

use App\Console\Commands\CrawlFiveM;
use App\Console\Commands\CreateServerListCache;
use App\Console\Commands\ParseCountryStats;
use App\Console\Commands\UpdateServerIcons;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CrawlFiveM::class,
        ParseCountryStats::class,
        CreateServerListCache::class,
        UpdateServerIcons::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('crawl:fivem')->everyFiveMinutes();
        $schedule->command('crawl:icons')->everyTenMinutes();
        $schedule->command('parse:countrystats')->everyThirtyMinutes();
        $schedule->command('cache:serverlist')->everyThirtyMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
