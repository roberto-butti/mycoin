<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteRockOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mycoin:deleterockorder
    {fund_id : The instrument of the order you want delete (LTCEUR, BTCEUR...)}
    {orderid : The ID of the order you want delete}
    
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a order by ID ORDER';

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
        
        $instrument = $this->argument('fund_id');
        $order_id = $this->argument('orderid');
        
        $result = \App\RockApi::order_delete($instrument, $order_id);
        //$headers=[];
        $this->info("Order Deleted:".$result["id"]);
        //$this->table($headers, $result);

        
    }
}
