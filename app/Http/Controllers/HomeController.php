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
        $promise = $client->sendAsync($request)->then(function ($response) {
            echo 'I completed! ' . $response->getBody();
        });
        //$promise->wait();
        
        //echo $res->getStatusCode();
        
        return $url;
    }

    public function getFunds() {
        $url = "https://api.therocktrading.com/v1/funds";
        return $url;
    }


}
