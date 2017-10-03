<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class CreateStatisticCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fivem:cache:dbstats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    protected $cacheValidity = 1440;

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
        $u = DB::select('SELECT COUNT(id) AS count FROM users');
        Cache::put('db:usercount', $u[0]->count, $this->cacheValidity);

        $p = DB::select('SELECT COUNT(id) AS count FROM player_statistics');
        Cache::put('db:playerstatscount', $p[0]->count, $this->cacheValidity);

        $s = DB::select('SELECT COUNT(id) AS count FROM servers');
        Cache::put('db:servercount', $s[0]->count, $this->cacheValidity);

        $s = DB::select('SELECT COUNT(id) AS count FROM server_histories');
        Cache::put('db:serverhistorycount', $s[0]->count, $this->cacheValidity);
    }
}
