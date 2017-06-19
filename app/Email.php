<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table = 'email';
    protected $fillable = [
        'email'
    ];

    static function getEmail(){
        $email = Email::all()->first();

        if ($email) {
            return $email->email;
        } else {
            return '';
        }
    }
}
