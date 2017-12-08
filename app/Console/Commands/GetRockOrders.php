<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetRockOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mycoin:getrockorders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List Your Order';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $apiKey=env("ROCKET_APIKEY");
        $apiSecret=env("ROCKET_SECRET");
        
        $fund_id="PPCEUR";
        
        $url="https://api.therocktrading.com/v1/funds/".$fund_id."/orders";
        
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
        if ($httpCode == 200) {
            $result=json_decode($callResult,true);
            foreach ($result["orders"] as $key => $value) {
                echo $value['id'];
                echo $value['fund_id'];
                echo $value['side'];
                
                echo $value['price'];
                echo $value['amount'];
                echo $value['status'];
                echo $value['type'];
                echo $value['amount_unfilled'];
                echo "---".$value['price'] * $value['amount']."---";
                
            }
            //print_r($result);    
        } else {
            echo "Error: $httpCode";
        }
        
    }
}
