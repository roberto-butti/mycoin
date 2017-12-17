<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetRockTrades extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mycoin:getrocktrades';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get My Last Trades';

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
        $fund_id="LTCEUR";
        
        $url="https://api.therocktrading.com/v1/funds/".$fund_id."/trades";
        
        $headers=array(
          "Content-Type: application/json"
        );
        
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $callResult=curl_exec($ch);
        curl_close($ch);
        
        $result=json_decode($callResult,true);
        
        print_r($result);
    }
}
