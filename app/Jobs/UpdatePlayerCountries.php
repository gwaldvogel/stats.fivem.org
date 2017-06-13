<?php

namespace App\Jobs;

use App\OverallStatistics;
use App\PlayerCountry;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdatePlayerCountries implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ipAdresses;
    protected $overallStatistics;

    /**
     * Create a new job instance.
     *
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
        $playerCount = [];
        $countryCodeToCountry = [];
        foreach ($this->ipAdresses as $ipAdress) {
            $location = geoip()->getLocation($ipAdress);
            if (!$location->default) {
                if (array_key_exists($location->iso_code, $playerCount)) {
                    $playerCount[$location->iso_code]++;
                } else {
                    $playerCount[$location->iso_code] = 1;
                }
                if (!array_key_exists($location->iso_code, $countryCodeToCountry)) {
                    $countryCodeToCountry[$location->iso_code] = $location->country;
                }
            }
        }

        foreach ($playerCount as $countryCode => $count) {
            $playerCountry = new PlayerCountry();
            $playerCountry->country = $countryCodeToCountry[$countryCode];
            $playerCountry->country_code = $countryCode;
            $playerCountry->overall_statistic_id = $this->overallStatistics->id;
            $playerCountry->clients = $count;
            $playerCountry->save();
        }
    }
}
