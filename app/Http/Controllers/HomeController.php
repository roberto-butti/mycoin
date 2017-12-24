<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currency = 'BTCEUR';
        $tickers = \App\Ticker::where('fund_id', $currency)
        ->select('date', 'last', 'fund_id')
        ->orderBy('date', 'desc')
        ->distinct()
        ->take(10)
        ->get();
        $ticker = $tickers[0];
        return view('home',['tickers' => $tickers, 'lastticker' => $ticker, 'currency' => $currency]);
    }

    public function dashboard() {
        $currency = "BTC";
        return view('dashboard',[ 'currency' => $currency]);

    }

    public function trades($instrument="BTCEUR") {
        return view('trades', ['instrument' => $instrument]);
    }

    public function getTickers() {
        $client = new \GuzzleHttp\Client();
        $url = "https://api.therocktrading.com/v1/funds/tickers";
        //$res = $client->request('GET', $url, [
            
        //]);
        $request = new \GuzzleHttp\Psr7\Request('GET', $url);
        $current_time = \Carbon\Carbon::now()->toDateTimeString();
        \Log::info($current_time.' - Get URL:'.$url);
        $promise = $client->sendAsync($request)->then(function ($response) {
            $current_time = \Carbon\Carbon::now()->toDateTimeString();
            \Log::info($current_time.' - sendasync status code::'.$response->getStatusCode());
            $json =  $response->getBody();
            $jobj = json_decode($json, true);
            foreach ($jobj['tickers'] as $key => $value) {
                $current_time = \Carbon\Carbon::now()->toDateTimeString();
                \Log::info($current_time.' - date from service: '.$value['date']." - ".$value["fund_id"]);
                $value['date'] = \Carbon\Carbon::parse($value['date'])->timezone('Europe/London');
                \Log::info($current_time.' - date from carbon: '.$value['date']." - ".$value["date"]->getTimezone()->getName());
                
                $ticker = \App\Ticker::create($value);
                
            }
            
            //$c = collect($jobj['tickers']);
        });
        $current_time = \Carbon\Carbon::now()->toDateTimeString();
        \Log::info($current_time.' - before promise URL:'.$url);
        $promise->wait();
        $current_time = \Carbon\Carbon::now()->toDateTimeString();
        \Log::info($current_time.' - after promise URL:'.$url);
        return $url;
    }

    public function getFunds() {
        $url = "https://api.therocktrading.com/v1/funds";
        return $url;
    }


}
