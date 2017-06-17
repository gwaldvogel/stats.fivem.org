<?php

namespace App\Jobs;

use App\Server;
use Carbon\Carbon;
use App\ServerHistory;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;

class UpdateServerStatistics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $serverData;
    protected $datetime;

    /**
     * Create a new job instance.
     *
     * @param  stdClass  $serverData
     * @param  Carbon  $datetime
     * @return void
     */
    public function __construct($serverData, Carbon $datetime)
    {
        $this->serverData = $serverData;
        $this->datetime = $datetime;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $endpoint = explode(':', $this->serverData->EndPoint);
        $ip = $endpoint[0];
        $port = $endpoint[1];
        $server = Server::where('ip', $ip)
            ->where('port', $port)
            ->first();

        if ($server) {
            $serverHistory = new ServerHistory();
            $serverHistory->server_id = $server->id;
            $serverHistory->name = $server->name;
            $serverHistory->gametype = $server->gametype;
            $serverHistory->mapname = $server->mapname;
            $serverHistory->clients = $server->clients;
            $serverHistory->created_at = $server->updated_at;
            $serverHistory->save();
        } else {
            $server = new Server();
            $server->ip = $ip;
            $server->port = $port;
            $location = $location = geoip()->getLocation($ip);
            if (! $location->default) {
                $server->country_code = $location->iso_code;
                $server->country = $location->country;
                $server->city = $location->city;
            }
        }

        foreach ($this->serverData->Data->players as $player) {
            if (substr($player->identifiers[0], 0, 5) == 'steam') {
                dispatch(new UpdatePlayerStatistics($player, $server->id));
            }
        }

        $server->name = $this->removeColorsFromServerName($this->serverData->Data->hostname);
        $server->gametype = $this->serverData->Data->gametype;
        $server->mapname = $this->serverData->Data->mapname;
        $server->clients = $this->serverData->Data->clients;
        $server->max_clients = $this->serverData->Data->svMaxclients;
        $server->icon = $this->fetchServerIcon($ip, $port);
        $server->save();

        Cache::put('fivem:worker:latest',
            Carbon::now()->toTimeString().': UpdateServerStatistics('.$this->serverData->EndPoint.')',
            10);
    }

    protected function removeColorsFromServerName($name)
    {
        $name = str_replace('^0', '', $name);
        $name = str_replace('^1', '', $name);
        $name = str_replace('^2', '', $name);
        $name = str_replace('^3', '', $name);
        $name = str_replace('^4', '', $name);
        $name = str_replace('^5', '', $name);
        $name = str_replace('^6', '', $name);
        $name = str_replace('^7', '', $name);
        $name = str_replace('^8', '', $name);
        $name = str_replace('^9', '', $name);

        return $name;
    }

    protected function fetchServerIcon($ip, $port)
    {
        $icon = null;
        try {
            $client = new Client([
                'base_uri' => 'http://'.$ip.':'.$port,
                'timeout' => 3.0,
            ]);

            $result = $client->request('GET', '/info.json');
            $result = json_decode($result->getBody());
            if (isset($result->icon)) {
                $hash = sha1($result->icon);
                $icon = $hash.'.png';
                $iconPath = public_path().'/server_icons/'.$icon;
                if (! file_exists($iconPath)) {
                    $image = base64_decode($result->icon);
                    file_put_contents($iconPath, $image);
                }
            }
        } catch (RequestException $e) {
            // whoops $this->info('Exception for ' . $ip . ':' . $port . ': ' . $e->getCode() . ' ' . $e->getMessage());
        }

        return $icon;
    }
}
