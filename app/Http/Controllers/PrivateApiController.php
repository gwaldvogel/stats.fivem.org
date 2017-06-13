<?php

namespace App\Http\Controllers;

use App\Server;
use Carbon\Carbon;
use App\CountryStats;
use App\OverallStatistics;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Cache;
use App\Console\Commands\ParseCountryStats;

class PrivateApiController extends Controller
{
    public function getPlayerCounts($ageInMinutes = 60)
    {
        $players = Cache::remember('api:playercount:'.$ageInMinutes, 5, function () use ($ageInMinutes) {
            $out = [];
            $overallStatistics = OverallStatistics::where('updated_at', '>', Carbon::now()->subMinutes($ageInMinutes))->get();

            foreach ($overallStatistics as $statistic) {
                $out['datetime'][] = $statistic->updated_at->toIso8601String();
                $out['playerCount'][] = $statistic->clients;
            }

            return $out;
        });

        return response()->json($players);
    }

    public function getServerCounts($ageInMinutes = 60)
    {
        $servers = Cache::remember('api:servercount:'.$ageInMinutes, 5, function () use ($ageInMinutes) {
            $out = [];
            $overallStatistics = OverallStatistics::where('updated_at', '>', Carbon::now()->subMinutes($ageInMinutes))->get();
            foreach ($overallStatistics as $statistic) {
                $out['datetime'][] = $statistic->updated_at->toIso8601String();
                $out['serverCount'][] = $statistic->servers;
            }

            return $out;
        });

        return response()->json($servers);
    }

    public function getServerAndPlayerCounts($ageInHours = 24)
    {
        $final = Cache::remember('api:playerservercount:hours:'.$ageInHours, 5, function () use ($ageInHours) {
            $out = [];
            $overallStatistics = OverallStatistics::where('updated_at', '>', Carbon::now()->subHours($ageInHours))->get();

            foreach ($overallStatistics as $statistic) {
                $out['datetime'][] = $statistic->updated_at->toIso8601String();
                $out['playerCount'][] = $statistic->clients;
                $out['serverCount'][] = $statistic->servers;
            }

            return $out;
        });

        return response()->json($final);
    }

    public function getCountryServerCount()
    {
        $countryStatsServer = Cache::remember('api:countrystatsserver', 5, function () {
            $stats = CountryStats::where('servers', '=', true)
                ->orderBy('updated_at', 'desc')
                ->first();

            $out = [];
            foreach ($stats->entries as $entry) {
                $out[ParseCountryStats::convertCountryCodeBack($entry->countryCode)] = $entry->value;
            }

            return $out;
        });

        return response()->json($countryStatsServer);
    }

    public function getCountryPlayerCount()
    {
        $countryStatsPlayers = Cache::remember('api:countrystatsplayer', 5, function () {
            $stats = CountryStats::where('servers', '=', false)
                ->orderBy('updated_at', 'desc')
                ->first();

            $out = [];
            foreach ($stats->entries as $entry) {
                $out[ParseCountryStats::convertCountryCodeBack($entry->countryCode)] = $entry->value;
            }

            return $out;
        });

        return response()->json($countryStatsPlayers);
    }

    public function getServerHistory($id)
    {
        $id = Hashids::decode($id)[0];

        $serverHistory = Cache::remember('api:server:'.$id.':history', 30, function () use ($id) {
            $server = Server::findOrFail($id);
            $out = [];
            $serverHistories = $server->histories()->where('created_at', '>', Carbon::now()->subHours(24))->get();
            foreach ($serverHistories as $history) {
                $out['datetime'][] = $history->created_at->toIso8601String();
                $out['playerCount'][] = $history->clients;
            }

            $out['datetime'][] = $server->updated_at->toIso8601String();
            $out['playerCount'][] = $server->clients;

            return $out;
        });

        return response()->json($serverHistory);
    }
}
