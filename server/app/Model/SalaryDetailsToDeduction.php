<?php

namespace App\Model;

class SalaryDetailsToDeduction extends BaseModel
{
    protected $table = 'salary_details_to_deduction';
    protected $primaryKey = 'salary_details_to_deduction_id';

    protected $fillable = [
        'salary_details_to_deduction_id', 'salary_details_id','deduction_id','amount_of_deduction'
    ];


}
