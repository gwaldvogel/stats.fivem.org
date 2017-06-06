<?php

namespace App\Console\Commands;

use App\Server;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Console\Command;

class UpdateServerIcons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:icons {all=false}';

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
        if($this->argument('all'))
            $servers = Server::all();
        else
            $servers = Server::whereNull('icon')->get();

        foreach($servers as $server)
        {
            try {
                $this->info('Handling: ' . $server->ipaddress);
                $client = new \GuzzleHttp\Client([
                    'base_uri' => 'http://' . $server->ipaddress,
                    'timeout' => 3.0,
                ]);

                $result = $client->request('GET', '/info.json');
                $result = json_decode($result->getBody());
                if(isset($result->icon))
                {
                    $hash = sha1($result->icon);
                    $server->icon = "/server_icons/" . $hash . ".png";
                    $path = public_path() . $server->icon;
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
                $this->error('Exception for ' . $server->ipaddress . ": " . $e->getCode() . " " . $e->getMessage());
            }

        }
        $this->info('Done after ' . round((microtime(true) - $start),3) . 'secs');
    }
}
