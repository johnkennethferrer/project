<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    protected $fillable = [
    	'name',
    	'description',
    	'status',
    	'user_id',
    ];

    // public function employees() {
    //     return $this->morphMany('App\Employee', 'commentable');
    // } 
}
