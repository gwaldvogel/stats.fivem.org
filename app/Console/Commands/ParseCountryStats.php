<?php

namespace App\Console\Commands;

use App\Player;
use App\Server;
use App\PlayerCrawl;
use App\CountryStats;
use App\CountryStatsEntry;
use App\User;
use Illuminate\Console\Command;

class ParseCountryStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses country statistics';

    protected static $countryCodes;

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
        $servers = Server::all();
        foreach ($servers as $server) {
            if (! $server->country || ! $server->country_code) {
                $this->info('Updating ' . $server->ip);
                $location = geoip()->getLocation($server->ip);
                if (! $location->default && $location->iso_code && $location->country) {
                    $server->country_code = $location->iso_code;
                    $server->country = $location->country;
                    $server->city = $location->city;
                    $server->save();
                }
                else
                {
                    $this->error('Failed for ' . $server->ip);
                }
            }
        }
    }
}
