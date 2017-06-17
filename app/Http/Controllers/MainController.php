<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\CountryStats;
use App\FiveMStatsCrawl;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index()
    {
        $fivemStatsLastH = Cache::remember('fivemstatscrawl', 5, function () {
            return FiveMStatsCrawl::where('updated_at', '>', Carbon::now()->subHours(1))->get();
        });

        $countryStatsServer = Cache::remember('countrystatsserver', 5, function () {
            return CountryStats::where('servers', '=', true)
                ->orderBy('updated_at', 'desc')
                ->first();
        });

        $countryStatsPlayers = Cache::remember('countrystatsplayers', 5, function () {
            return CountryStats::where('servers', '=', false)
                ->orderBy('updated_at', 'desc')
                ->first();
        });

        return view('index', [
            'FiveMLastHour' => $fivemStatsLastH,
            'CountryStatsServer' => $countryStatsServer->entries,
            'CountryStatsPlayers' => $countryStatsPlayers->entries, ]);
    }

    public function dashboard()
    {
        $users = Cache::remember('db:usercount', 5, function () {
            $u = DB::select('SELECT COUNT(id) AS count FROM users');
            return $u[0]->count;
        });

        $playerstatistics = Cache::remember('db:playerstatscount', 5, function () {
            $p = DB::select('SELECT COUNT(id) AS count FROM player_statistics');
            return $p[0]->count;
        });


        $servers = Cache::remember('db:servercount', 5, function () {
            $s = DB::select('SELECT COUNT(id) AS count FROM servers');
            return $s[0]->count;
        });

        $serverhistories = Cache::remember('db:serverhistorycount', 5, function () {
            $s = DB::select('SELECT COUNT(id) AS count FROM server_histories');
            return $s[0]->count;
        });

        return view('dashboard', [
            'userCount' => $users,
            'playerRecords' => $playerstatistics,
            'serverCount' => $servers,
            'serverHistoryRecords' => $serverhistories,
        ]);
    }

    public function serversByCountry()
    {
        return view('serversMap');
    }

    public function playersByCountry()
    {
        return view('playersMap');
    }
}
