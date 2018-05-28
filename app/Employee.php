<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    //
    use SoftDeletes;
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

    protected $dates = ['deleted_at'];

    // public function company() {
    //     return $this->belongsTo('App\Company');
    // }

    public function employee() {
        return $this->belongsTo('App\User');
    }
}
