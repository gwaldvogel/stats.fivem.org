<?php

namespace App\Http\Controllers;

use App\Server;
use Vinkla\Hashids\Facades\Hashids;

class ServerController extends Controller
{
    public function getServer($hash)
    {
        $server = Server::findOrFail(Hashids::decode($hash)[0]);
        if ($server) {
            return view('server', ['server' => $server]);
        }
    }
}
