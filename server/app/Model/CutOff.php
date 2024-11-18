<?php

namespace App\Model;

class CutOff extends BaseModel
{
    protected $primaryKey = 'id';
    protected $table = 'cut_off';
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
    ];
}
