<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    public function histories()
    {
        return $this->hasMany('App\ServerHistory');
    }
}
