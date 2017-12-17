<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PostRockOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mycoin:postrockorder
    {fund_id : The instrument of the order you want create (LTCEUR, BTCEUR...)}
    {--action=}
    {--amount=}
    {--price=}


    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert NEW order';

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
        $action = $this->option('action');
        $amount = $this->option('amount');
        $price = $this->option('price');

        $fund_id = \strtoupper($fund_id);

        if ($amount=="") {
            $this->error("Error, AMOUNT not found");
            exit(-1);
        }
        if ($price=="") {
            $this->error("Error, PRICE not found");
            exit(-1);
        }
        $side = "buy";
        if (strtolower($action) == "sell" ) {
            $side = "sell";
        }
        
        $params=array(
            "fund_id"=>$fund_id,
            "side"=>$side,
            "amount"=>$amount,
            "price"=>$price
        );
        $this->info(json_encode($params,JSON_PRETTY_PRINT));
        $this->info("Total: ".$params['price'] * $params['amount']);
        if ($this->confirm("Sicuro?")) {
            $result = \App\RockApi::order_create($fund_id, $params);
            dd($result);
            //$this->info("Order Created:".$result["id"]);    
        } else {
            $this->info("Order not Created:");    
        }
        
    }
}
