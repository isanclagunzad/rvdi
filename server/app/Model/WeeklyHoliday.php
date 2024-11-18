<?php

namespace App\Model;

class WeeklyHoliday extends BaseModel
{
    protected $table = 'weekly_holiday';
    protected $primaryKey = 'week_holiday_id';

    protected $fillable = [
        'week_holiday_id', 'day_name','status'
    ];
}
