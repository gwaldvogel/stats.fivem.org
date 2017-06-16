<?php

namespace App\Http\Controllers;

use App\Server;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class ServerController extends Controller
{
    public function serverList()
    {
        $serversArray = [];
        if (Cache::has('servers:array')) {
            $serversArray = Cache::get('servers:array');
        }

        return view('serverList', [
            'servers' => $serversArray,
        ]);
    }

    public function getServer($hash)
    {
        $server = Server::findOrFail(Hashids::decode($hash)[0]);
        if ($server) {
            return view('server', ['server' => $server]);
        }
    }

    public function searchServerView()
    {
        return view('searchserver');
    }

    public function searchServer(Request $request)
    {
        if(strlen($request->input('search')) < 3)
        {
            $request->session()->flash('alert-danger', 'Your search string has to have at least 3 digits!');
            return redirect('/search/server');
        }

        $servers = Server::where('ip', $request->input('search'))->get();
        if($servers->isEmpty())
            $servers = Server::where('name', 'like', '%'.$request->input('search').'%')->get();

        if($servers->count() > 1)
        {
            return view('searchserver', ['servers' => $servers]);
        }
        else
            return redirect('/server/'.Hashids::encode($servers[0]->id));
    }
}
