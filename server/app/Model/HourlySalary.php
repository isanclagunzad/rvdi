<?php

namespace App\Model;

class HourlySalary extends BaseModel
{
    protected $table = 'hourly_salaries';
    protected $primaryKey = 'hourly_salaries_id';

    protected $fillable = [
        'hourly_salaries_id','hourly_grade','hourly_rate'
    ];
}
