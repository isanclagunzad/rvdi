<?php

namespace App\Model;

class PayGradeType extends BaseModel
{
    const HOURLY = 'Hourly';
    const MONTHLY = 'Monthly';
    const DAILY = 'Daily';

    protected $fillable = ['name'];

    public function payGrades()
    {
        return $this->hasMany(PayGrade::class);
    }
}
