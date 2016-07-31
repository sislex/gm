<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calculator extends Model
{
    protected $table = 'calculator';
    protected $fillable = [
        'name',
        'value'
    ];
}
