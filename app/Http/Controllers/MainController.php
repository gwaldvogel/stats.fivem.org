<?php

namespace App\Http\Controllers;

use App\FiveMStatsCrawl;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $fivemStatsLastH = FiveMStatsCrawl::where('updated_at', '>', Carbon::now()->subHours(1))->get();
        return view('index', ['FiveMLastHour' => $fivemStatsLastH]);
    }
}
