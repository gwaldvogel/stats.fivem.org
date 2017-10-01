<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class MainController extends Controller
{
    public function redirectToDashboard()
    {
        return redirect('/dashboard');
    }

    public function dashboard()
    {
        $users = 0;
        if (Cache::has('db:usercount')) {
            $users = Cache::get('db:usercount');
        }

        $playerstatistics = 0;
        if (Cache::has('db:playerstatscount')) {
            $playerstatistics = Cache::get('db:playerstatscount');
        }

        $servers = 0;
        if (Cache::has('db:servercount')) {
            $servers = Cache::get('db:servercount');
        }

        $serverhistories = 0;
        if (Cache::has('db:serverhistorycount')) {
            $serverhistories = Cache::get('db:serverhistorycount');
        }

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

    public function credits()
    {
        return view('credits');
    }
}
