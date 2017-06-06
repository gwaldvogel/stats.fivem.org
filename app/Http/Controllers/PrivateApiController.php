<?php

namespace App\Http\Controllers;

use App\Console\Commands\ParseCountryStats;
use App\CountryStats;
use App\FiveMStatsCrawl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PrivateApiController extends Controller
{
    public function getPlayerCounts($ageInMinutes = 60)
    {
        $players = Cache::remember('api:playercount:' . $ageInMinutes, 5, function() use ($ageInMinutes) {
            $out = [];
            $crawls = FiveMStatsCrawl::where('updated_at', '>', Carbon::now()->subMinutes($ageInMinutes))->get();

            if($ageInMinutes == 60)
                $format = 'H:i:s';
            else
                $format = 'Y-m-d H:i:s';

            foreach($crawls as $id => $crawl)
            {
                $out['datetime'][] = $crawl->updated_at->format($format);
                $out['playerCount'][] = $crawl->playerCount;
            }
            return $out;
        });

        return response()->json($players);
    }

    public function getServerCounts($ageInMinutes = 60)
    {
        $servers = Cache::remember('api:servercount:' . $ageInMinutes, 5, function() use ($ageInMinutes) {
            $out = [];
            $crawls = FiveMStatsCrawl::where('updated_at', '>', Carbon::now()->subMinutes($ageInMinutes))->get();
            foreach($crawls as $id => $crawl)
            {
                $out['datetime'][] = $crawl->updated_at->format('Y-m-d H:i:s');
                $out['serverCount'][] = $crawl->serverCount;
            }
            return $out;
        });

        return response()->json($servers);
    }

    public function getSeverAndPlayerCounts($ageInHours = 24)
    {
        $final = Cache::remember('api:playerservercount:hours:' . $ageInHours, 5, function() use ($ageInHours) {
            $out = [];
            $crawls = FiveMStatsCrawl::where('updated_at', '>', Carbon::now()->subHours($ageInHours))->get();

            $format = 'Y-m-d H:i:s';
            foreach($crawls as $id => $crawl)
            {
                $out['datetime'][] = $crawl->updated_at->format($format);
                $out['playerCount'][] = $crawl->playerCount;
                $out['serverCount'][] = $crawl->serverCount;
            }
            return $out;
        });

        return response()->json($final);
    }

    public function getCountryServerCount()
    {
        $countryStatsServer = Cache::remember('api:countrystatsserver', 5, function() {
            $stats = CountryStats::where('servers', '=', true)
                ->orderBy('updated_at', 'desc')
                ->first();

            $out = [];
            foreach($stats->entries as $entry)
            {
                $out[ParseCountryStats::convertCountryCodeBack($entry->countryCode)] = $entry->value;
            }

            return $out;
        });
        return response()->json($countryStatsServer);
    }

    public function getCountryPlayerCount()
    {
        $countryStatsPlayers = Cache::remember('api:countrystatsplayer', 5, function() {
            $stats = CountryStats::where('servers', '=', false)
                ->orderBy('updated_at', 'desc')
                ->first();

            $out = [];
            foreach($stats->entries as $entry)
            {
                $out[ParseCountryStats::convertCountryCodeBack($entry->countryCode)] = $entry->value;
            }

            return $out;
        });

        return response()->json($countryStatsPlayers);
    }
}