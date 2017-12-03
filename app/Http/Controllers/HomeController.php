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
        return view('home');
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
