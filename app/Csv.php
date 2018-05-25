<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Csv extends Model
{

    protected $table = 'csv';

    protected $fillable = ['csv_filename', 'csv_data'];

}
