<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Model\Department;
use App\Model\Designation;
use App\Model\Employee;
use App\Model\Role;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;

class BnrController extends Controller
{
    protected $repository;

    public function __construct(EmployeeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $departmentList  = Department::get();
        $designationList = Designation::get();
        $roleList        = Role::get();

        $results = Employee::with(
            [
                'user.role',
                'department',
                'designation',
                'branch',
                'payGrade',
                'supervisor',
                'hourlySalaries'
            ]
        )->orderBy('employee_id', 'DESC')->paginate(10);

        if (request()->ajax()) {
            $results =  $this->repository->advancedSearch($request)->paginate(10);

            return View('admin.employee.employee.pagination', ['results' => $results])->render();
        }

        return view('admin.employee.employee.index', ['results' => $results, 'departmentList' => $departmentList, 'designationList' => $designationList, 'roleList' => $roleList]);
    }
}
