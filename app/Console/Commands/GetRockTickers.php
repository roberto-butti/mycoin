<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetRockTickers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mycoin:getrocktickers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retreive Tickers from RockTrading';

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
        
        $client = new \GuzzleHttp\Client();
        $url = "https://api.therocktrading.com/v1/funds/tickers";
        $this->info("Getting ".$url);
        //$request = new \GuzzleHttp\Psr7\Request('GET', $url);
        $response = $client->request('GET', $url);
        $json =  $response->getBody();
        $jobj = json_decode($json, true);
        foreach ($jobj['tickers'] as $key => $value) {
            $current_time = \Carbon\Carbon::now()->toDateTimeString();
            $this->info('Date from service: '.$value['date']." - ".$value["fund_id"]);
            $value['date'] = \Carbon\Carbon::parse($value['date'])->timezone('Europe/London');
            $this->info('Date from carbon: '.$value['date']." - ".$value["date"]->getTimezone()->getName());
            $ticker = \App\Ticker::create($value);
        }
        $this->info("DONE ".$url);

    }
}
