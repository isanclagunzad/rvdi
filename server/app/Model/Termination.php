<?php

namespace App\Model;

class Termination extends BaseModel
{
    protected $table = 'termination';
    protected $primaryKey = 'termination_id';

    protected $fillable = [
        'termination_id', 'terminate_to','terminate_by','termination_type','subject','notice_date','termination_date','description','status'
    ];

    public function terminateTo()
    {
        return $this->belongsTo(Employee::class,'terminate_to');
    }

    public function terminateBy()
    {
        return $this->belongsTo(Employee::class,'terminate_by');
    }

}
