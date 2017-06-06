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
    protected $signature = 'crawl:icons';

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

        $servers = Server::whereNull('icon')->get();
        foreach($servers as $server)
        {
            $url = 'http://' . $server->ipaddress . '/info.json';
            $result = file_get_contents($url, false, $context);
            $result = json_decode($result);
            $server->icon = $result->icon;
            $server->save();
        }
    }
}
