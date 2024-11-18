<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Model\AuthenticatableUser;
use App\Model\Employee;
use App\Model\Role;


class User extends AuthenticatableUser
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user';
    protected $primaryKey = 'user_id';

    protected $fillable = ['user_id','role_id','user_name','password','status','created_by','updated_by'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role() 
    {
        return $this->hasOne(Role::class,'role_id', 'role_id');
    }

    public function employee() 
    {
        return $this->hasOne(Employee::class, 'user_id', 'user_id');
    }
}
