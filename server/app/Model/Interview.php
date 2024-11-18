<?php

namespace App\Model;

class Interview extends BaseModel
{
    protected $table = 'interview';
    protected $primaryKey = 'interview_id';

    protected $fillable = [
        'interview_id', 'job_applicant_id','interview_date','interview_time','interview_type','comment'
    ];
}
