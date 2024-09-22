<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'coin_type', 'name', 'symbol', 'current_price', 'created_at', 'updated_at',
    ];
}
