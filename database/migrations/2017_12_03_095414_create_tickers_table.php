<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTickersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickers', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('fund_id');
            $table->double('bid');
            $table->double('ask');
            $table->double('last');
            $table->double('open');
            $table->double('close');
            $table->double('low');
            $table->double('high');
            $table->double('volume');
            $table->double('volume_traded');
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickers');
    }
}
