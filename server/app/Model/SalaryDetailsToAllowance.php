<?php

namespace App\Model;

class SalaryDetailsToAllowance extends BaseModel
{
    protected $table = 'salary_details_to_allowance';
    protected $primaryKey = 'salary_details_to_allowance_id';

    protected $fillable = [
        'salary_details_to_allowance_id', 'salary_details_id','allowance_id','amount_of_allowance'
    ];
}
