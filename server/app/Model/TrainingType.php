<?php

namespace App\Model;

class TrainingType extends BaseModel
{
    protected $table = 'training_type';
    protected $primaryKey = 'training_type_id';

    protected $fillable = [
        'training_type_id', 'training_type_name','status'
    ];
}
