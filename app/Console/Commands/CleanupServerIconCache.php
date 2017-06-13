<?php

namespace App\Console\Commands;

use App\Server;
use Illuminate\Console\Command;

class CleanupServerIconCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:cleanup:servericons';

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
        $directory = public_path().'/server_icons/';
        $files = scandir($directory);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..' && $file != '.gitignore') {
                $server = Server::where('icon', '=', $file)->first();
                if (! $server) {
                    unlink($directory.$file);
                }
            }
        }
    }
}
