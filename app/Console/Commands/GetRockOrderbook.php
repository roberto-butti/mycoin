<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetRockOrderbook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mycoin:getrockorderbook { fund_id : the instrument of the orderbook (LTCEUR, BTCEUR...)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Orderbook of Instrument';

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
        
        $fund_id = $this->argument('fund_id');
        $result = \App\RockApi::orderbook($fund_id);
        $headers=["Price",'Quantity','Depth EUR'];
        $this->info("ASK (SELL) you want Sell");
        $this->table($headers, array_slice($result["asks"], 0, 3));
        $this->info("BID (BUY) you want Buy");
        $this->table($headers, array_slice($result["bids"], 0, 3));
    }
}
