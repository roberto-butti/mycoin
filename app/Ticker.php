<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticker extends Model
{
    //
    protected $fillable = ['date','fund_id','bid','ask','last','open','close','low','high','volume','volume_traded'];

    
}
