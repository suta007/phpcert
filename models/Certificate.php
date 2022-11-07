<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Certificate extends Eloquent
{
    protected $table = 'certificates';
    protected $primaryKey = 'id';
    //public $incrementing = false;
    //public $timestamps = false;

    protected $fillable = [
        'name',
        'user_id',
        'date_at',
        'sheet',

        'code_name',
        'num',
        'year',
        'pattern',
        'code_right',
        'code_top',
        'code_font',
        'code_size',
        'code_number',
        'code_color',
        'code_weight',
        'i_digit',

        'name_top',
        'name_font',
        'name_size',
        'name_color',
        'name_weight',

        'line2_top',
        'line2_font',
        'line2_size',
        'line2_color',
        'line2_weight',

        'line3_top',
        'line3_font',
        'line3_size',
        'line3_color',
        'line3_weight',

        'orientation',
        'line',
        'bg',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
