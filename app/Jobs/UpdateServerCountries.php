<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\ServerCountry;
use App\OverallStatistics;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateServerCountries implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ipAdresses;
    protected $overallStatistics;

    /**
     * Create a new job instance.
     *
     * @param  array  $ipAdresses
     * @param  OverallStatistics  $overallStatistics
     * @return void
     */
    public function __construct(array $ipAdresses, OverallStatistics $overallStatistics)
    {
        $this->ipAdresses = $ipAdresses;
        $this->overallStatistics = $overallStatistics;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $serverCount = [];
        $countryCodeToCountry = [];
        foreach ($this->ipAdresses as $ipAdress) {
            $location = geoip()->getLocation($ipAdress);
            if (! $location->default) {
                if (array_key_exists($location->iso_code, $serverCount)) {
                    $serverCount[$location->iso_code]++;
                } else {
                    $serverCount[$location->iso_code] = 1;
                }
                if (! array_key_exists($location->iso_code, $countryCodeToCountry)) {
                    $countryCodeToCountry[$location->iso_code] = $location->country;
                }
            }
        }

        foreach ($serverCount as $countryCode => $count) {
            $serverCountry = new ServerCountry();
            $serverCountry->country = $countryCodeToCountry[$countryCode];
            $serverCountry->country_code = $countryCode;
            $serverCountry->overall_statistic_id = $this->overallStatistics->id;
            $serverCountry->servers = $count;
            $serverCountry->save();
        }
        Cache::put('fivem:worker:latest',
            Carbon::now()->toTimeString().': UpdateServerCountries',
            10);
    }
}
