<?php

namespace App\Model;

class PayGrade extends BaseModel
{
    protected $table = 'pay_grade';
    protected $primaryKey = 'pay_grade_id';

    protected $fillable = [
        'pay_grade_id',
        'pay_grade_name',
        'gross_salaryPayGrade',
        'percentage_of_basic',
        'basic_salary',
        'overtime_rate',
        'pay_grade_type_id'
    ];

    public function payGradeType()
    {
        return $this->belongsTo(PayGradeType::class, 'pay_grade_type_id');
    }

    public function allowances()
    {
        return $this->belongsToMany(
            Allowance::class,
            'pay_grade_to_allowance',
            'pay_grade_id',
            'allowance_id'
        );
    }

    public function deductions()
    {
        return $this->belongsToMany(
            Deduction::class,
            'pay_grade_to_deduction',
            'pay_grade_id',
            'deduction_id'
        );
    }

    public function type()
    {
        return $this->hasOne(PayGradeType::class, 'id', 'pay_grade_type_id');
    }
}
