<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexesToTickersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickers', function (Blueprint $table) {
            $table->index('fund_id', 'idx_tickers_fund_id');
            $table->index('date', 'idx_tickers_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickers', function (Blueprint $table) {
            $table->dropIndex('idx_tickers_fund_id');
            $table->dropIndex('idx_tickers_date');

        });
    }
}
