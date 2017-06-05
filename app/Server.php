<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $table = 'servers';
    protected $fillable = ['ipaddress'];

    public function crawls()
    {
        return $this->hasMany('App\ServerCrawl', 'server_id');
    }
}
