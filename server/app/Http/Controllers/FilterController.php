<?php

namespace App\Http\Controllers;

use App\Model\Branch;
use App\Model\Department;
use App\Model\Designation;
use App\Model\Employee;
use App\Model\Role;

class FilterController extends Controller
{
    public function index() {
        $gender = [ 'Male', 'Female'];
        $employees = Employee::select(
            'employee_id', 
            'first_name', 
            'middle_name', 
            'last_name'
        )->get()->all();
        $department = Department::all();
        $branches = Branch::all();
        $roles = Role::all();
        $designations = Designation::all();

        return compact('gender', 'employees', 'department', 'branches', 'roles', 'designations');
    }
}
