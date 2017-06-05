<?php

namespace App\Http\Controllers;

use App\CountryStats;
use App\FiveMStatsCrawl;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $fivemStatsLastH = FiveMStatsCrawl::where('updated_at', '>', Carbon::now()->subHours(1))->get();

        $countryStatsServer = CountryStats::where('servers', '=', true)
            ->orderBy('updated_at', 'desc')
            ->first();

        $countryStatsPlayers = CountryStats::where('servers', '=', false)
            ->orderBy('updated_at', 'desc')
            ->first();

        return view('index', [
            'FiveMLastHour' => $fivemStatsLastH,
            'CountryStatsServer' => $countryStatsServer->entries,
            'CountryStatsPlayers' => $countryStatsPlayers->entries]);
    }
}
