<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryStats extends Model
{
    protected $table = 'country_stats';

    public function entries()
    {
        return $this->hasMany('App\CountryStatsEntry');
    }
}
