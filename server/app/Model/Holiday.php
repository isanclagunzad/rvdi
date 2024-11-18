<?php

namespace App\Model;

class Holiday extends BaseModel
{
    protected $table = 'holiday';
    protected $primaryKey = 'holiday_id';

    protected $fillable = [
        'holiday_id', 'holiday_name'
    ];

    public function details()
    {
        return $this->belongsTo(HolidayDetails::class, 'holiday_details_id', 'holiday_id');
    }
}
