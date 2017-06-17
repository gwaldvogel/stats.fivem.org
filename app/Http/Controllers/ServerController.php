<?php

namespace App\Http\Controllers;

use App\Server;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Cache;

class ServerController extends Controller
{
    public function serverList()
    {
        $serversArray = [];
        if (Cache::has('servers:array')) {
            $serversArray = Cache::get('servers:array');
        }

        return view('serverList', [
            'servers' => $this->paginate($serversArray, 25),
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
        if (strlen($request->input('search')) < 3) {
            $request->session()->flash('alert-danger', 'Your search string has to have at least 3 digits!');

            return redirect('/search/server');
        }

        $servers = Server::where('ip', $request->input('search'))->get();
        if ($servers->isEmpty()) {
            $servers = Server::where('name', 'like', '%'.$request->input('search').'%')->get();
        }

        if ($servers->count() > 1) {
            return view('searchserver', ['servers' => $servers]);
        } else {
            return redirect('/server/'.Hashids::encode($servers[0]->id));
        }
    }

    protected function paginate($items, $perPage)
    {
        if(is_array($items)){
            $items = collect($items);
        }

        return new LengthAwarePaginator(
            $items->forPage(Paginator::resolveCurrentPage() , $perPage),
            $items->count(), $perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );
    }
}
