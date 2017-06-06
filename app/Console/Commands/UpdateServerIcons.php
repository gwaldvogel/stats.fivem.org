<?php

namespace App\Console\Commands;

use App\Server;
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
        $opts = array('http' =>
            array(
                'timeout' => 5
            )
        );
        $context  = stream_context_create($opts);

        if($this->argument('all'))
            $servers = Server::all();
        else
            $servers = Server::whereNull('icon')->get();

        foreach($servers as $server)
        {
            $url = 'http://' . $server->ipaddress . '/info.json';
            $result = @file_get_contents($url, false, $context);
            if($result !== false)
            {
                $this->info('Processing info for ' . $server->ipaddress);
                $result = json_decode($result);
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
        }
    }
}
