<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateGitVersion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'git:version';

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
        $gitHash = trim(shell_exec('git rev-parse HEAD'));
        $gitShortHash = trim(shell_exec('git rev-parse --short HEAD'));
        $envFile = file_get_contents($this->laravel->environmentFilePath());
        $envFile = str_replace('GIT_HASH='.env('GIT_HASH'), 'GIT_HASH='.$gitHash, $envFile);
        $envFile = str_replace('GIT_SHORTHASH='.env('GIT_SHORTHASH'), 'GIT_SHORTHASH='.$gitShortHash, $envFile);
        file_put_contents($this->laravel->environmentFilePath(), $envFile);
    }
}
