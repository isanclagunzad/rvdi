<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class Branch extends BaseModel
{
    protected $table = 'branch';
    protected $primaryKey = 'branch_id';

    protected $fillable = [
        'branch_id', 'branch_name'
    ];

    /**
     * 
     * @param Builder $query
     * @return Collection 
     */
    public function scopeEmployees($query) 
    {
        return $query
            ->select('branch.branch_name', DB::raw('COUNT(employee.branch_id) as employees'))
            ->leftJoin('employee', 'branch.branch_id', '=', 'employee.branch_id')
            ->groupBy('branch.branch_name')
            ->get()
            ->mapWithKeys(function($item) {
                return [
                    $item->branch_name => $item->employees
                ];
            });
    }
}
