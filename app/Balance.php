<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $fillable = ['currency','balance','trading_balance','user_id'];
    
    /**
     * Get the user that owns the balance.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
