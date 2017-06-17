<?php

namespace App\Http\Controllers;

use App\User;
use App\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    public function searchPlayerView()
    {
        return view('searchplayer');
    }

    public function searchPlayer(Request $request)
    {
        if (strlen($request->input('search')) < 3) {
            $request->session()->flash('alert-danger', 'Your search string has to have at least 3 digits!');

            return redirect('/search/player');
        }

        $users = User::where('steam_id', $request->input('search'))->get();
        if ($users->isEmpty()) {
            $users = User::where('nickname', 'like', '%'.$request->input('search').'%')->get();
        }

        if ($users->count() > 1) {
            return view('searchplayer', ['users' => $users]);
        } else {
            return redirect('/player/'.$users[0]->steam_id);
        }
    }

    public function getPlayer($steamId, $toggle = false)
    {
        $user = User::where('steam_id', $steamId)->first();
        if (! $user) { // user does not exist
            abort(404);
        } elseif ($toggle != false && $user->id == Auth::user()->id) { // toggling hidden status
            $user->hidden = $user->hidden ? false : true;
            $user->save();
        } elseif ($user->hidden && $user->id != Auth::user()->id) { // hidden and not himself
            abort(403);
        }

        $statistics = $user->playerStatistics()->orderBy('updated_at', 'DESC')->get();
        if ($statistics->isEmpty()) {
            return view('player', [
                'user' => $user,
                'latest' => null,
                'statistics' => null,
                'avgPing' => -1,
                'servers' => null,
            ]);
        }
        $latest = $statistics[0];

        $servers = [];
        $favorite = [];
        $serverPing = [];
        $pings = [];
        $pingCount = 0;
        foreach ($statistics as $statistic) {
            $servers[$statistic->server_id] = [
                'name' => Server::find($statistic->server_id)->name,
                'icon' => Server::find($statistic->server_id)->icon,
            ];

            if (array_key_exists($statistic->server_id, $favorite)) {
                $favorite[$statistic->server_id] += 1;
            } else {
                $favorite[$statistic->server_id] = 1;
            }

            $serverPing[$statistic->server_id][] = $statistic->ping;
            $pings[] = $statistic->ping;
            $pingCount++;
        }

        foreach ($serverPing as $s => $ping) {
            $avgPing = 0;
            foreach ($ping as $p) {
                $avgPing += $p;
            }
            $servers[$s]['avgPing'] = $avgPing / $favorite[$s];
        }

        $avgPing = 0;
        foreach ($pings as $ping) {
            $avgPing += $ping;
        }
        $avgPing = round($avgPing / $pingCount, 1);

        return view('player', [
            'user' => $user,
            'latest' => $latest,
            'statistics' => $statistics,
            'avgPing' => $avgPing,
            'servers' => $servers,
        ]);
    }

    public function playerlist()
    {
        $users = User::where('hidden', false)->paginate(25);

        return view('playerlist', ['users' => $users]);
    }
}
