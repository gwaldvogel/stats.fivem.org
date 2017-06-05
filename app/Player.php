<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['identifier'];
    public function crawls()
    {
        return $this->hasMany('App\PlayerCrawl', 'unique_player_id');
    }
}
