<?php

namespace App\Model;

class LeaveType extends BaseModel
{
    protected $table = 'leave_type';
    protected $primaryKey = 'leave_type_id';

    protected $fillable = [
        'leave_type_id', 'leave_type_name','num_of_day'
    ];
}
