<?php

namespace App;



class RockApi {

    private static function callPrivateApi($url) {

        $apiKey=env("ROCKET_APIKEY");
        $apiSecret=env("ROCKET_SECRET");
        
        

        $nonce=microtime(true)*10000;
        $signature=hash_hmac("sha512",$nonce.$url,$apiSecret);
        
        $headers=array(
          "Content-Type: application/json",
          "X-TRT-KEY: ".$apiKey,
          "X-TRT-SIGN: ".$signature,
          "X-TRT-NONCE: ".$nonce
        );
        
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"GET");
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $callResult=curl_exec($ch);
        $httpCode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);
        $result = false;
        if ($httpCode == 200) {
            $result=json_decode($callResult,true);                
        }
        return $result;

    }

    public static function callApi($url) {
        $client = new \GuzzleHttp\Client();
        //$request = new \GuzzleHttp\Psr7\Request('GET', $url);
        $response = $client->request('GET', $url);
        $json =  $response->getBody();
        $jobj = json_decode($json, true);
        return $jobj;
    }

    public static function tickers() {
        $url = "https://api.therocktrading.com/v1/funds/tickers";
        $result = self::callApi($url);
        return $result;
    }
    public static function balances()
    {
        $url="https://api.therocktrading.com/v1/balances";
        $result = self::callPrivateApi($url);
        $email=env("ROCKET_EMAIL");


        $user = \App\User::where('email', $email)->first();
        
        foreach ($result["balances"] as $key => $value) {
            //echo $value['currency'];
            //echo $value['balance'];
            //echo $value['trading_balance'];
            $bal = \App\Balance::updateOrCreate(
                ['currency' => $value['currency'],'user_id'=>$user->id],
                [
                    'currency' => $value['currency'],
                    'balance' => $value['balance'],
                    'trading_balance'=>$value['trading_balance'],
                    'user_id'=>$user->id
                ]
            );
            //echo "---".$value['price'] * $value['amount']."---";
        }

        return true;

    }
}