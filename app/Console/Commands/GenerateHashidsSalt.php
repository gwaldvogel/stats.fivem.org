<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateHashidsSalt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hashids:salt';

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
        $salt = sha1(microtime() . (time() * rand(0,94851)) . time());
        $envFile = file_get_contents($this->laravel->environmentFilePath());
        $envFile = str_replace('HASHIDS_SALT='.env('HASHIDS_SALT'), 'HASHIDS_SALT='.$salt, $envFile);
        file_put_contents($this->laravel->environmentFilePath(), $envFile);
    }
}
