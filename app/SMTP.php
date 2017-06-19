<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMTP extends Model
{
    protected $table = 'smtp_settings';
    protected $fillable = [
        'login',
        'password',
        'server',
        'port',
        'security',
        'description'
    ];
}
