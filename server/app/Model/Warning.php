<?php

namespace App\Model;

class Warning extends BaseModel
{
    protected $table = 'warning';
    protected $primaryKey = 'warning_id';

    protected $fillable = [
        'warning_id', 'warning_to','warning_type','subject','warning_by','warning_date','description'
    ];

    public function warningTo(){
        return $this->belongsTo(Employee::class,'warning_to');
    }

    public function warningBy(){
        return $this->belongsTo(Employee::class,'warning_by');
    }


}
