<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Cache;

class CreateServerListCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:serverlist';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $start = microtime(true);
        $outArray = [];
        $servers = DB::table('servers')->orderBy('clients', 'DESC')->get();

        foreach ($servers as $server) {
            $outArray[] = [
                'id' => Hashids::encode($server->id),
                'name' => strlen($server->name) > 63 ? substr($server->name, 0, 60).'...' : $server->name,
                'ipaddress' => $server->ip.':'.$server->port,
                'lastUpdated' => $server->updated_at,
                'icon' => empty($server->icon) ? null : '/server_icons/'.$server->icon,
                'countryCode' => $server->country_code,
                'country' => $server->country,
                'clients' => $server->clients,
                'maxClients' => $server->max_clients,
            ];
        }
        Cache::put('servers:array', $outArray, 30);
        $this->info('Done in '.round(microtime(true) - $start, 3).' secs');
    }
}
