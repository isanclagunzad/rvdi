<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class Designation extends BaseModel
{
    protected $table = 'designation';
    protected $primaryKey = 'designation_id';

    protected $fillable = [
        'designation_id', 'designation_name'
    ];

    /**
     * @param Builder $query
     * @return Collection 
     */
    public function scopeEmployees($query)
    {
        return $query
            ->groupBy('designation.designation_id')
            ->select('designation.designation_name', DB::raw('COUNT(employee.branch_id) as employees'))
            ->leftJoin('employee', 'employee.designation_id', '=', 'designation.designation_id')
            ->get()
            ->mapWithKeys(function($item) {
                return [
                    $item->designation_name => $item->employees
                ];
            });
    }
}
