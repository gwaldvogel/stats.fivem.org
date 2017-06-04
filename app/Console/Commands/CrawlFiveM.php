<?php

namespace App\Console\Commands;

use App\FiveMStatsCrawl;
use App\PlayerCrawl;
use App\Server;
use App\ServerCrawl;
use Illuminate\Console\Command;

class CrawlFiveM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:fivem';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawls the FiveM master server for data';

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
        $this->info('Fetching data from API');
        $apiData = file_get_contents('http://runtime.fivem.net/servers');
        $apiData = json_decode($apiData);
        $this->info('Data received. Processing...');
        $fiveMStatsCrawl = new FiveMStatsCrawl();
        //var_dump($apiData);
        foreach($apiData as $server)
        {
            $data = $server->Data;
            $ip = $server->EndPoint;
            $this->info('Processing server ' . $ip);
            $fiveMStatsCrawl->playerCount += $data->clients;
            $fiveMStatsCrawl->serverCount++;

            $serverObj = Server::firstOrCreate(['ipaddress' => $ip]);
            if($serverObj->ipaddress != $ip)
                $serverObj->ipaddress = $ip;


            $ip = explode(':', $ip);
            $ip = $ip[0];

            $location = geoip()->getLocation($ip);
            if(!$location->default)
            {
                $serverObj->countryCode = $location->iso_code;
                $serverObj->country = $location->country;
                $serverObj->city = $location->city;
            }

            $serverObj->save();

            $serverCrawl = new ServerCrawl();
            $serverCrawl->server_id             = $serverObj->id;
            $serverCrawl->clients               = $data->clients;

            if(property_exists($data, 'enhancedHostSupport'))
                $serverCrawl->enhancedHostSupport = $data->enhancedHostSupport;
            else
                $serverCrawl->enhancedHostSupport = false;

            $serverCrawl->gamename              = $data->gamename;
            $serverCrawl->gametype              = $data->gametype;
            $serverCrawl->hostname              = $data->hostname;

            if(property_exists($data, 'iconVersion'))
                $serverCrawl->iconVersion           = $data->iconVersion;
            $serverCrawl->lastSeen              = $data->lastSeen;
            $serverCrawl->mapname               = $data->mapname;
            $serverCrawl->protocol              = $data->protocol;
            $serverCrawl->resources             = json_encode($data->resources);
            $serverCrawl->server                = $data->server;
            $serverCrawl->svMaxclients          = $data->svMaxclients;
            $serverCrawl->sv_maxclients         = $data->sv_maxclients;
            $serverCrawl->save();

            foreach($data->players as $player)
            {
                $playerObj = new PlayerCrawl();
                $playerObj->server_crawl_id = $serverCrawl->id;
                $playerIp = explode(':', $player->endpoint);
                $playerIp = $playerIp[0];
                if(filter_var($playerIp, FILTER_VALIDATE_IP))
                    $playerObj->endpoint = $player->endpoint;
                else
                    $playerObj->endpoint = 'hidden';
                $playerObj->fivemId = $player->id;
                $playerObj->identifier = $player->identifiers[0];
                $playerObj->name = $player->name;
                $playerObj->ping = $player->ping;

                if($playerObj->endpoint != 'hidden')
                {
                    $playerLocation = geoip()->getLocation($playerIp);
                    if(!$playerLocation->default)
                    {
                        $playerObj->countryCode = $playerLocation->iso_code;
                        $playerObj->country = $playerLocation->country;
                        $playerObj->city = $playerLocation->city;
                        $playerObj->lat = $playerLocation->lat;
                        $playerObj->lon = $playerLocation->lon;
                    }
                }
                $playerObj->save();
            }
        }
        $fiveMStatsCrawl->save();
        $this->info($fiveMStatsCrawl->playerCount . ' players on ' . $fiveMStatsCrawl->serverCount . ' servers crawled.');
    }
}
