<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{

    protected $table = "currency";

    protected $fillable = [
        'flag','currency_name_key', 'cur_bye', 'cur_sell'
    ];

}
