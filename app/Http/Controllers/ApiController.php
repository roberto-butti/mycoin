<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getListTickers()
    {
        $currency = 'PPCEUR';
        $tickers = \App\Ticker::where('fund_id', $currency)
        ->select('date', 'last', 'fund_id')
        ->orderBy('date', 'desc')
        ->distinct()
        ->take(10)
        ->get();
        return $tickers;
        //return view('home',['tickers' => $tickers, 'lastticker' => $ticker, 'currency' => $currency]);
    }

    public function getLastTicker() {
        $currency = 'PPCEUR';
        $ticker = \App\Ticker::where('fund_id', $currency)
        ->select('date', 'last', 'fund_id')
        ->orderBy('date', 'desc')
        ->first();
        return $ticker; 
        
    }



}
