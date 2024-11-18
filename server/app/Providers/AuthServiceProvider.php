<?php

namespace App\Providers;

use App\Model\CustomField;
use App\Policies\CustomFieldPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\DB;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        CustomField::class => CustomFieldPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        Gate::define('see-upcoming-birthday', function($user) {
            $role_id = session('logged_session_data.role_id');
            $permissions = DB::table('menus')
                            ->join('menu_permission', 'menu_permission.menu_id', '=', 'menus.id')
                            ->where('role_id', $role_id)
                            ->whereIn('name', ['Manage Employee'])
                            ->get();

            return $permissions->isNotEmpty();                     
        });

        Gate::define('see-employee-performance', function($user) {
            $role_id = session('logged_session_data.role_id');
            $permissions = DB::table('menus')
                            ->join('menu_permission', 'menu_permission.menu_id', '=', 'menus.id')
                            ->where('role_id', $role_id)
                            ->whereIn('name', ['Manage Employee', 'Employee Performance'])
                            ->get();

            return $permissions->isNotEmpty();                     
        });

        Gate::define('see-employee-award', function($user) {
            $role_id = session('logged_session_data.role_id');
            $permissions = DB::table('menus')
                            ->join('menu_permission', 'menu_permission.menu_id', '=', 'menus.id')
                            ->where('role_id', $role_id)
                            ->whereIn('name', ['Manage Employee', 'Award'])
                            ->get();

            return $permissions->isNotEmpty();                     
        });

        Gate::define('see-employee-categorisation', function($user) {
            $role_id = session('logged_session_data.role_id');
            $permissions = DB::table('menus')
                            ->join('menu_permission', 'menu_permission.menu_id', '=', 'menus.id')
                            ->where('role_id', $role_id)
                            ->whereIn('name', ['Manage Employee'])
                            ->get();

            return $permissions->isNotEmpty();                     
        });

        Gate::define('see-employee-total', function($user) {
            $role_id = session('logged_session_data.role_id');
            $permissions = DB::table('menus')
                            ->join('menu_permission', 'menu_permission.menu_id', '=', 'menus.id')
                            ->where('role_id', $role_id)
                            ->whereIn('name', ['Manage Employee'])
                            ->get();

            return $permissions->isNotEmpty();                     
        });

        Gate::define('see-department-total', function($user) {
            $role_id = session('logged_session_data.role_id');
            $permissions = DB::table('menus')
                            ->join('menu_permission', 'menu_permission.menu_id', '=', 'menus.id')
                            ->where('role_id', $role_id)
                            ->whereIn('name', ['Manage Employee', 'Department'])
                            ->get();

            return $permissions->isNotEmpty();                     
        });

        Gate::define('see-attendance-total', function($user) {
            $role_id = session('logged_session_data.role_id');
            $permissions = DB::table('menus')
                            ->join('menu_permission', 'menu_permission.menu_id', '=', 'menus.id')
                            ->where('role_id', $role_id)
                            ->whereIn('name', ['Manage Employee'])
                            ->get();

            return $permissions->isNotEmpty();                     
        });

        Gate::define('see-between-dates-attendance', function($user) {
            $role_id = session('logged_session_data.role_id');
            $permissions = DB::table('menus')
                            ->join('menu_permission', 'menu_permission.menu_id', '=', 'menus.id')
                            ->where('role_id', $role_id)
                            ->whereIn('name', ['Manage Employee', 'Daily Attendance', 'Monthly Attendance'])
                            ->get();

            return $permissions->isNotEmpty();                     
        });

        Gate::define('access-custom-fields', function($user) {
            $role_id = session('logged_session_data.role_id') ?? auth()->guard('api')->user()->role->role_id;

            $permissions = DB::table('menus')
                            ->join('menu_permission', 'menu_permission.menu_id', '=', 'menus.id')
                            ->where('role_id', $role_id)
                            ->whereIn('name', ['Manage Employee'])
                            ->get();

            return $permissions->isNotEmpty();   
        });

        Gate::define('manage-employee', function($user) {
            $role_id = session('logged_session_data.role_id') ?? auth()->guard('api')->user()->role->role_id;

            $permissions = DB::table('menus')
                            ->join('menu_permission', 'menu_permission.menu_id', '=', 'menus.id')
                            ->where('role_id', $role_id)
                            ->whereIn('name', ['Manage Employee'])
                            ->get();

            return $permissions->isNotEmpty();   
        });
    }
}
