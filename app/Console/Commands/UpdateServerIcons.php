<?php

namespace App\Console\Commands;

use App\Server;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class UpdateServerIcons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:icons {all?}';

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
        if($this->argument('all') == true)
        {
            $this->info('Rebuilding all server icons');
            $servers = Server::all();
        }
        else
            $servers = Server::whereNull('icon')->get();

        foreach($servers as $server)
        {
            try {
                $this->info('Handling: ' . $server->ip.':'.$server->port);
                $client = new Client([
                    'base_uri' => 'http://' . $server->ip.':'.$server->port,
                    'timeout' => 2.0,
                ]);

                $result = $client->request('GET', '/info.json');
                $result = json_decode($result->getBody());
                if(isset($result->icon))
                {
                    $hash = sha1($result->icon);
                    $server->icon = $hash . ".png";
                    $path = public_path() . "/server_icons/" . $server->icon;
                    if(!file_exists($path))
                    {
                        $image = base64_decode($result->icon);
                        file_put_contents($path, $image);
                    }
                    $server->save();
                }
            }
            catch(RequestException $e)
            {
                $this->error('Exception for ' . $server->ip.':'.$server->port . ": " . $e->getCode() . " " . $e->getMessage());
            }

        }
        $this->info('Done after ' . round((microtime(true) - $start),3) . 'secs');
    }
}
