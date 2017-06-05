<?php

namespace App\Http\Controllers;

use App\CountryStats;
use App\FiveMStatsCrawl;
use App\Server;
use App\ServerCrawl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MainController extends Controller
{
    public function index()
    {
        $fivemStatsLastH = Cache::remember('fivemstatscrawl', 5, function() {
           return FiveMStatsCrawl::where('updated_at', '>', Carbon::now()->subHours(1))->get();
        });

        $countryStatsServer = Cache::remember('countrystatsserver', 5, function() {
            return CountryStats::where('servers', '=', true)
                ->orderBy('updated_at', 'desc')
                ->first();
        });

        $countryStatsPlayers = Cache::remember('countrystatsplayers', 5, function() {
            return CountryStats::where('servers', '=', false)
                ->orderBy('updated_at', 'desc')
                ->first();
        });

        return view('index', [
            'FiveMLastHour' => $fivemStatsLastH,
            'CountryStatsServer' => $countryStatsServer->entries,
            'CountryStatsPlayers' => $countryStatsPlayers->entries]);
    }

    public function serverList()
    {
        $serversArray = [];
        $servers = Cache::remember('servers', 5, function(){
            return Server::all();
        });
        foreach($servers as $server)
        {
            $crawl =ServerCrawl::where('server_id', '=', $server->id)
                ->orderBy('updated_at', 'desc')
                ->first();

            // remove colors
            $name = str_replace('^0', '', $crawl->hostname);
            $name = str_replace('^1', '', $name);
            $name = str_replace('^2', '', $name);
            $name = str_replace('^3', '', $name);
            $name = str_replace('^4', '', $name);
            $name = str_replace('^5', '', $name);
            $name = str_replace('^6', '', $name);
            $name = str_replace('^7', '', $name);
            $name = str_replace('^8', '', $name);
            $name = str_replace('^9', '', $name);

            $serversArray[] = [
                'name' => $name,
                'ipaddress' => $server->ipaddress,
                'lastUpdated' => $crawl->updated_at
            ];
        }
        return view('serverList', [
            'servers' => $serversArray
        ]);
    }
}
