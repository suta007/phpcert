<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    //public $incrementing = false;
    //public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'name',
        'email',
        'type',
        'last_login'
    ];

    protected $hidden = [
        'password',
    ];
}
