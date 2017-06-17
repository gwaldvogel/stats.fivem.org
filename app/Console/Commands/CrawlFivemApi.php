<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\OverallStatistics;
use Illuminate\Console\Command;
use App\Jobs\UpdatePlayerCountries;
use App\Jobs\UpdateServerCountries;
use App\Jobs\UpdateServerStatistics;

class CrawlFivemApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl';

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
        $start = microtime(true);
        $this->info('Fetching data from API');
        $apiData = file_get_contents('http://runtime.fivem.net/api/servers/');
        $apiData = json_decode($apiData);
        $datetime = Carbon::now();
        $this->info('Data received. Processing...');

        $overallStatistics = new OverallStatistics();
        $ipAdresses = [];
        $playerIpAdresses = [];

        foreach ($apiData as $server) {
            $overallStatistics->clients += $server->Data->clients;
            $overallStatistics->servers++;
            $ipAdresses[] = explode(':', $server->EndPoint)[0];
            dispatch(new UpdateServerStatistics($server, $datetime));

            foreach ($server->Data->players as $player) {
                // This only works as long as these IPs are pure IPv4
                $playerIp = explode(':', $player->endpoint);
                $playerIp = $playerIp[0];
                if (filter_var($playerIp, FILTER_VALIDATE_IP)) {
                    $playerIpAdresses[] = $playerIp;
                }
            }
        }
        $overallStatistics->save();

        dispatch(new UpdatePlayerCountries($playerIpAdresses, $overallStatistics));
        dispatch(new UpdateServerCountries($ipAdresses, $overallStatistics));

        $this->info($overallStatistics->clients.' players on '.$overallStatistics->servers.' servers crawled in '.(microtime(true) - $start).' secs.');
    }
}
