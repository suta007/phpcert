<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Person extends Eloquent
{
    //protected $table = 'people';
    protected $primaryKey = 'id';
    //public $incrementing = false;
    //public $timestamps = false;

    protected $fillable = [
        'certificate_id',
        'name',
        'line2',
        'line3',
        'i',
    ];
}
