<?php

namespace App\Model;

class SalaryDetailsToLeave extends BaseModel
{
    protected $table = 'salary_details_to_leave';
    protected $primaryKey = 'salary_details_to_leave_id';

    protected $fillable = [
        'salary_details_to_leave_id', 'salary_details_id','leave_type_id','num_of_day'
    ];

}
