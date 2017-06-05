<?php

namespace App\Console\Commands;

use App\CountryStats;
use App\CountryStatsEntry;
use App\Player;
use App\PlayerCrawl;
use App\Server;
use Illuminate\Console\Command;

class ParseCountryStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:countrystats';

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
        $playerCountries = [];
        $countryCodesToCountries = [];
        $players = Player::all();
        foreach($players as $player)
        {
            $crawl = PlayerCrawl::where('unique_player_id', '=', $player->id)
                ->orderBy('updated_at', 'desc')
                ->first();

            if(!empty($crawl->country) && !empty($crawl->countryCode))
            {
                if(array_key_exists($crawl->country, $playerCountries))
                    $playerCountries[$crawl->country]++;
                else
                    $playerCountries[$crawl->country] = 1;

                $countryCodesToCountries[$crawl->country] = $crawl->countryCode;
            }
        }

        $countryStats = new CountryStats();
        $countryStats->servers = false;
        $countryStats->save();
        foreach($playerCountries as $country => $value)
        {
            $countryStatsEntry = new CountryStatsEntry();
            $countryStatsEntry->country_stats_id = $countryStats->id;
            $countryStatsEntry->country = $country;
            $countryStatsEntry->countryCode = ParseCountryStats::convertCountryCode($countryCodesToCountries[$country]);
            $countryStatsEntry->value = $value;
            $countryStatsEntry->save();
        }



        $serverCountries = [];
        $servers = Server::all();
        foreach($servers as $server)
        {
            if(!empty($server->country) && !empty($server->countryCode))
            {
                if(array_key_exists($server->country, $serverCountries))
                    $serverCountries[$server->country]++;
                else
                    $serverCountries[$server->country] = 1;

                $countryCodesToCountries[$server->country] = $server->countryCode;
            }
        }

        $countryStats = new CountryStats();
        $countryStats->servers = true;
        $countryStats->save();
        foreach($serverCountries as $country => $value)
        {
            $countryStatsEntry = new CountryStatsEntry();
            $countryStatsEntry->country_stats_id = $countryStats->id;
            $countryStatsEntry->country = $country;
            $countryStatsEntry->countryCode = ParseCountryStats::convertCountryCode($countryCodesToCountries[$country]);
            $countryStatsEntry->value = $value;
            $countryStatsEntry->save();
        }
    }

    public static function convertCountryCode($countryCode)
    {
        if(!isset(self::$countryCodes))
        {
            self::$countryCodes = json_decode(file_get_contents('http://country.io/iso3.json'));
        }
        $countryCode = strtoupper($countryCode);
        return isset(self::$countryCodes->$countryCode) ? self::$countryCodes->$countryCode : $countryCode;
    }
}
