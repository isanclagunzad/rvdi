<?php

namespace App\Model;

class PayGradeToAllowance extends BaseModel
{
    protected $table = 'pay_grade_to_allowance';
    protected $primaryKey = 'pay_grade_to_allowance_id';

    protected $fillable = [
        'pay_grade_to_allowance_id',
        'pay_grade_id',
        'allowance_id'
    ];
}
