<?php

namespace App\Http\Controllers;

use App\CountryStats;
use App\FiveMStatsCrawl;
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
}
