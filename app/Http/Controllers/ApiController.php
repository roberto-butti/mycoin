<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getListTickers()
    {
        $currency = 'BTCEUR';
        $tickers = \App\Ticker::where('fund_id', $currency)
        ->select('date', 'last', 'fund_id', 'bid', 'ask')
        ->orderBy('date', 'desc')
        ->distinct()
        ->take(10)
        ->get();
        return $tickers;
        //return view('home',['tickers' => $tickers, 'lastticker' => $ticker, 'currency' => $currency]);
    }

    public function getLastTicker() {
        $currency = 'BTCEUR';
        $ticker = \App\Ticker::where('fund_id', $currency)
        ->select('date', 'last', 'fund_id')
        ->orderBy('date', 'desc')
        ->first();
        return $ticker; 
        
    }


    public function analyzeTickers()
    {
        $qry_date = '2017-12-04 12:05';
        $qry_currency = 'BTCEUR';
        $qty = 3.5;
        $value = 2.8;
        $tot = $qty*$value;
        

        $tickers = \App\Ticker::where('fund_id', $qry_currency)
        ->where('date', '>=', $qry_date)
        ->select('date', 'last', 'fund_id', 'bid', 'ask')
        ->orderBy('date', 'asc')
        ->distinct()
        
        ->get();

        $ts = $tickers->toArray();

        $percentiles = [0.5, 1,2,3,4,5,10];
        echo "<h1>$tot</h1";
        foreach ($percentiles as $key => $percentile) {
            //$percentile = 1;
            $hotpoint = $tot + ($tot*$percentile/100);
            echo "<br><h1>$percentile</h1> $hotpoint | ";
            $res=[];
            $buy=true;
            foreach ($ts as $key => $value) {
                $currenttotal= $value['last']*$qty;
                $istransaction=false;

                if ($buy) {
                    
                    if ($currenttotal >= $hotpoint) {
                        echo "<br/><b>+$currenttotal ($hotpoint)</b>";
                        $res[] = $value;
                        //$hotpoint = $currenttotal - ($currenttotal*$percentile/100);
                        $hotpoint = $hotpoint - ($hotpoint*$percentile/100);
                        $buy = false;
                        $istransaction = true;
                    }
                } else {
                    if ($currenttotal <= $hotpoint) {
                        echo "<br/><b>-$currenttotal ($hotpoint)</b>";
                        $res[] = $value;
                        //$hotpoint = $currenttotal + ($currenttotal*$percentile/100);
                        $hotpoint = $hotpoint + ($hotpoint*$percentile/100);
                        $buy = true;
                        $istransaction = true;
                    }
                }
                if (!$istransaction) {
                    echo $currenttotal ." | ";
                }
                    
            }
        }
        //dd($res);
        return "";

        //return view('home',['tickers' => $tickers, 'lastticker' => $ticker, 'currency' => $currency]);
    }


}
