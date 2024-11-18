<?php

namespace App\Model;

class WorkShift extends BaseModel
{
    protected $table = 'work_shift';
    protected $primaryKey = 'work_shift_id';

    protected $fillable = [
        'work_shift_id', 'shift_name','start_time','end_time','late_count_time'
    ];
}
