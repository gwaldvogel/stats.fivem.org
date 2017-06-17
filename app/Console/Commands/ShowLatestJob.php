<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ShowLatestJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:latest';

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
        $latest = null;
        $duplicates = [];
        $messages = [];
        while(true) {
            $current = Cache::get('fivem:worker:latest', '');
            if($current != $latest) {
                if(array_search($current, $messages)) {
                    $this->error('Duplicate: '.$current);
                    $duplicates[] = $current;
                }
                $messages[] = $current;
                $this->info($current);
                $latest = $current;
            }
        }
    }
}
