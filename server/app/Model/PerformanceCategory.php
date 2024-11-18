<?php

namespace App\Model;

class PerformanceCategory extends BaseModel
{
    protected $table = 'performance_category';
    protected $primaryKey = 'performance_category_id';

    protected $fillable = [
        'performance_category_id', 'performance_category_name'
    ];
}
