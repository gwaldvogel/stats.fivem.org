<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OverallStatistics extends Model
{
    public function serverCountries()
    {
        return $this->hasMany('App\ServerCountry');
    }

    public function playerCountries()
    {
        return $this->hasMany('App\PlayerCountry');
    }
}
