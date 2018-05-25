<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    //
    protected $fillable = [
    	'employee_id',
    	'time_in',
    	'time_out'
    ];
}
