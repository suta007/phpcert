<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Sheet extends Eloquent
{
    //protected $table = 'people';
    protected $primaryKey = 'id';
    //public $incrementing = false;
    //public $timestamps = false;

    protected $fillable = [
        'certificate_id',
        'link',
        'pre',
        'col',
        'test',
        'score',
        'pass',

    ];
}
