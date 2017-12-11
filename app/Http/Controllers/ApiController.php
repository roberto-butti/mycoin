<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    private function getLastTickerByCurrency($currency) {
        return \App\Ticker::where('fund_id', $currency)
        ->select('date', 'last', 'fund_id')
        ->orderBy('date', 'desc')
        ->first();
    }

    public function getLastTicker() {
        
        return $this->getLastTickerByCurrency("BTCEUR");
        
        
    }

    private function calculateIntermediate($currency_from, $currency_to,$balance=0,  $prefix="intermediate") {
        $row = [];
        $currency_from = strtoupper($currency_from);
        $currency_to = strtoupper($currency_to);

        $instrument = $currency_from.$currency_to;
        $lastTicker = $this->getLastTickerByCurrency($instrument);
        $needtomultiply = true;
        if ( ! $lastTicker) {
            $instrument = $currency_to.$currency_from;
            $lastTicker = $this->getLastTickerByCurrency($instrument);
            $needtomultiply = false;
        }
        Log::info('instrument: '.$instrument);
        $moltiplicator = 1;
        if ($lastTicker) {
            Log::info('c1: '.$currency_from);
            Log::info('c2: '.$currency_to);
            $moltiplicator = $lastTicker->last;
            $moltiplicator = ($currency_to == $currency_from) ? 1 : $moltiplicator;

            $row[$prefix."_instrument"] = $instrument;
            $row[$prefix."_currency"] = $currency_to;
            $row[$prefix."_change"] = $moltiplicator;
            
            if ($needtomultiply) {
                $row[$prefix."_value"] = $balance * $moltiplicator;
                $row[$prefix."_operation"] = "*";
            } else {
                $row[$prefix."_value"] = $moltiplicator / $balance;
                $row[$prefix."_operation"] = "/";
            }
            
    
        } else {
            Log::info('c1: '.$currency_from);
            Log::info('c2: '.$currency_to);
            Log::info('same currency, no instrument');
            $row[$prefix."_instrument"] = $instrument;
            $row[$prefix."_currency"] = $currency_to;
            $row[$prefix."_change"] = 1;
            $row[$prefix."_value"] = $balance;
            $row[$prefix."_operation"] = "*";

        }
        return $row;
    }

    public function getBalances($currency="PPC") {
        $email=env("ROCKET_EMAIL");
        $user = \App\User::where('email', $email)->first();
        //$user;
        $balances = $user->balances;
        //dd($balances);
        //return $balances;
        $retval = [];
        $row = [];
        $finalCurrency="EUR";
        $intermediateCurrecy=$currency;
        foreach ($balances as $key => $value) {
             # code...
            if ($value["balance"] != 0 ) {
                $row = $value->toArray();
                $prefix1 = "intermediate";
                $row1 = $this->calculateIntermediate($value["currency"], $intermediateCurrecy, $value["balance"], $prefix1);
                //print_r($row);
                $row = array_merge($row, $row1);
                $prefix2 = "finale";
                $row2 = $this->calculateIntermediate($intermediateCurrecy, $finalCurrency, $row[$prefix1."_value"], $prefix2);
                //print_r($row);
                $row = array_merge($row, $row2);
                
                /*
                $instrument = strtoupper($value["currency"]).$intermediateCurrecy;

                $lastTicker = $this->getLastTickerByCurrency($instrument);
                $moltiplicator = ($lastTicker) ? $lastTicker->last : 0;
                $moltiplicator = ($instrument == "EUREUR") ? 1 : $moltiplicator;
                $row["intermediate1_instrument"] = $instrument;
                $row["intermediate1_currency"] = $intermediateCurrecy;
                $row["intermediate1_value"] = $value["balance"] / $moltiplicator;
    
                $instrument = $intermediateCurrecy.strtoupper($value["currency"]);
                $lastTicker = $this->getLastTickerByCurrency($instrument);
                $moltiplicator = ($lastTicker) ? $lastTicker->last : 0;
                $moltiplicator = ($instrument == "EUREUR") ? 1 : $moltiplicator;
                $row["intermediate2_instrument"] = $instrument;
                $row["intermediate2_currency"] = $intermediateCurrecy;
                $row["intermediate2_moltiplicator"] = $moltiplicator;
                $row["intermediate2_value"] = number_format($value["balance"] * $moltiplicator, 8, '.', ' ');;
                */
                //$row["eur"] = $value["balance"] * $moltiplicator;
                //echo $value->currency;
                $retval[] = $row;
                //dd($value);
    
            }
        }
        return $retval;

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
