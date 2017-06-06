<?php

namespace App\Console\Commands;

use App\Server;
use App\ServerCrawl;
use Illuminate\Console\Command;
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
        $outArray = [];
        $servers = Server::all();

        foreach($servers as $server)
        {
            $start = microtime(true);
            $this->info('Creating cache for ' . $server->ipaddress);
            $crawl = ServerCrawl::where('server_id', '=', $server->id)
                ->orderBy('updated_at', 'desc')
                ->first();

            // remove colors
            $name = str_replace('^0', '', $crawl->hostname);
            $name = str_replace('^1', '', $name);
            $name = str_replace('^2', '', $name);
            $name = str_replace('^3', '', $name);
            $name = str_replace('^4', '', $name);
            $name = str_replace('^5', '', $name);
            $name = str_replace('^6', '', $name);
            $name = str_replace('^7', '', $name);
            $name = str_replace('^8', '', $name);
            $name = str_replace('^9', '', $name);

            $outArray[] = [
                'name' => $name,
                'ipaddress' => $server->ipaddress,
                'lastUpdated' => $crawl->updated_at
            ];
            $this->info('Done after ' . (microtime(true) - $start) . ' msecs');
        }
        Cache::put('servers:array', $outArray, 30);
    }
}
