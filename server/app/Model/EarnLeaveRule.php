<?php

namespace App\Model;

class EarnLeaveRule extends BaseModel
{
    protected $table = 'earn_leave_rule';
    protected $primaryKey = 'earn_leave_rule_id';

    protected $fillable = [
        'earn_leave_rule_id', 'for_month','day_of_earn_leave'
    ];
}
