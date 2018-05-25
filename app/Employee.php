<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $fillable = [
    	'first_name',
    	'middle_name',
    	'last_name',
    	'gender',
    	'address',
    	'status',
    	'user_id',
    	'company_id',
    ];

    // public function company() {
    //     return $this->belongsTo('App\Company');
    // }

    public function employee() {
        return $this->belongsTo('App\User');
    }
}
