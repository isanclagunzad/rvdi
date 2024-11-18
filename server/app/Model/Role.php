<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class Role extends BaseModel
{
    protected $table = 'role';
    protected $primaryKey = 'role_id';

    protected $fillable = [
        'role_name'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }

    /**
     * @param Builder $query
     * @return Collection 
     */
    public function scopeEmployees($query)
    {
        return $query->leftJoin('user', 'role.role_id', '=', 'user.role_id')
            ->select('role.role_name', DB::raw('COALESCE(COUNT(user.role_id), 0) as total'))
            ->groupBy('role.role_name')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->role_name => $item->total];
            });
    }
}
