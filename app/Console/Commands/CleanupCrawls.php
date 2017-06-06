<?php

namespace App\Console\Commands;

use App\PlayerCrawl;
use App\ServerCrawl;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class CleanupCrawls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:crawls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        if (App::isLocal())
        {
            $crawls = ServerCrawl::where('updated_at', '<', Carbon::now()->subWeek(1))->get();
            foreach($crawls as $crawl)
            {
                $crawl->delete();
            }

            $players = PlayerCrawl::where('updated_at', '<', Carbon::now()->subWeek(1))->get();
            foreach($players as $player)
            {
                $player->delete();
            }
        }
    }
}
