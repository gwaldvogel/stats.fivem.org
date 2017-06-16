<?php

namespace App\Jobs;

use App\PlayerStatistic;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdatePlayerStatistics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $player;
    protected $serverId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($player, $serverId)
    {
        $this->player = $player;
        $this->serverId = $serverId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $steam_id = hexdec(substr($this->player->identifiers[0], 6));
        $name = $this->player->name;
        $ping = $this->player->ping;
        $user = User::where('steam_id', $steam_id)->first();
        if(!$user)
        {
            try {
                $client = new Client([
                    'base_uri' => 'http://api.steampowered.com',
                    'timeout' => 3.0,
                ]);

                $result = $client->request('GET', '/ISteamUser/GetPlayerSummaries/v0002/?key=' . env('STEAM_KEY') . '&steamids=' . $steam_id);
                $result = json_decode($result->getBody());

                if (isset($result->response) && array_key_exists(0, $result->response->players)) {
                    $user = new User();
                    $user->nickname = $result->response->players[0]->personaname;
                    $user->avatar = $result->response->players[0]->avatar;
                    $user->steam_id = $steam_id;
                    $user->save();
                }
                else
                {
                    return;
                }
            } catch (RequestException $e) {
                return;
            }
        }

        if ($this->serverId == null) {
            return;
        }

        $playerStatistic = new PlayerStatistic();
        $playerStatistic->user_id = $user->id;
        $playerStatistic->server_id = $this->serverId;
        $playerStatistic->ping = $ping;
        $playerStatistic->name = $name;
        $playerStatistic->save();
    }
}
