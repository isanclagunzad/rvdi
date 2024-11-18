<?php

namespace App\Model;

class Allowance extends BaseModel
{
    protected $table = 'allowance';
    protected $primaryKey = 'allowance_id';

    protected $fillable = [
        'allowance_id',
        'allowance_name',
        'allowance_type',
        'percentage_of_basic',
        'limit_per_month',
        'is_active'
    ];

    public function paygrades()
    {
        return $this->belongsToMany(PayGrade::class, 'pay_grade_to_allowance', 'allowance_id', 'pay_grade_id');
    }
}
