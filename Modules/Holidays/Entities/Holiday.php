<?php

namespace Modules\Holidays\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Holiday extends Model
{
    use SoftDeletes;

    protected $fillable = ['holiday_name', 'holiday_date'];
}
