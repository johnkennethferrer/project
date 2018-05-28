<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Company extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
    	'name',
    	'description',
    	'status',
    	'user_id',
    ];

    protected $dates = ['deleted_at'];

    // public function employees() {
    //     return $this->morphMany('App\Employee', 'commentable');
    // } 
}
