<?php

namespace App\Console;

use App\Console\Commands\CrawlFivemApi;
use App\Console\Commands\UpdateGitVersion;
use App\Console\Commands\ParseCountryStats;
use App\Console\Commands\UpdateServerIcons;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\GenerateHashidsSalt;
use App\Console\Commands\CreateServerListCache;
use App\Console\Commands\CleanupServerIconCache;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ParseCountryStats::class,
        CreateServerListCache::class,
        UpdateServerIcons::class,
        UpdateGitVersion::class,
        GenerateHashidsSalt::class,
        CrawlFivemApi::class,
        CleanupServerIconCache::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('crawl')->everyFiveMinutes();
        $schedule->command('crawl:icons')->twiceDaily();
        $schedule->command('cache:serverlist')->everyThirtyMinutes();
        $schedule->command('cache:cleanup:servericons')->daily();
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
