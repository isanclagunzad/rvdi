<?php

namespace App\Model;

class Deduction extends BaseModel
{
    protected $table = 'deduction';
    protected $primaryKey = 'deduction_id';

    protected $fillable = [
        'deduction_id',
        'deduction_name',
        'deduction_type',
        'percentage_of_basic',
        'limit_per_month',
        'is_active'
    ];

    public function paygrades()
    {
        return $this->belongsToMany(PayGrade::class, 'pay_grade_to_deduction','deduction_id', 'pay_grade_id');
    }
}
