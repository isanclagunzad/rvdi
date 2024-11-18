<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class Department extends BaseModel
{
    protected $table = 'department';
    protected $primaryKey = 'department_id';

    protected $fillable = [
        'department_id', 'department_name'
    ];

    /**
     * 
     * @param Builder $query 
     * @return Collection 
     */
    public function scopeEmployees($query)
    {
        return $query->select(
            DB::raw('department.department_name AS department'),
            DB::raw('COUNT(employee.department_id) as employees') 
        )->join(
            'employee', 
            'employee.department_id', '=', 'department.department_id'
        )->groupBy('employee.department_id')
         ->get()
         ->mapWithKeys(function($item) {
            return [$item->department => $item->employees];
         });
    }
}
