<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeFetchRequest;
use App\Http\Requests\EmployeeRequest;
use App\Model\Branch;
use App\Model\Department;
use App\Model\Designation;
use App\Model\Employee;
use App\Model\EmployeeEducationQualification;
use App\Model\EmployeeExperience;
use App\Model\HourlySalary;
use App\Model\PayGrade;
use App\Model\PayGradeType;
use App\Model\PrintHeadSetting;
use App\Model\Role;
use App\Model\WorkShift;
use App\Repositories\EmployeeRepository;
use App\Services\PayGradeService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    protected $repository;

    public function __construct(EmployeeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(EmployeeFetchRequest $request)
    {
        $departmentList = Department::get();
        $designationList = Designation::get();
        $roleList = Role::get();

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
        )->orderBy('employee_id', 'DESC')->paginate($request->get('page_size'));

        if (request()->ajax()) {
            $results = $this->repository->advancedSearch($request)->paginate($request->get('page_size'));

            return View('admin.employee.employee.pagination', ['results' => $results])->render();
        }

        return view('admin.employee.employee.index', ['results' => $results, 'departmentList' => $departmentList, 'designationList' => $designationList, 'roleList' => $roleList]);
    }

    public function apiList(EmployeeFetchRequest $request)
    {
        $this->authorize('manage-employee');

        $departmentList = Department::get();
        $designationList = Designation::get();
        $roleList = Role::get();

        $results = $this->repository
            ->advancedSearch($request)
            ->with([
                'user.role',
                'department',
                'designation',
                'branch',
                'payGrade',
                'supervisor',
                'hourlySalaries',
                'customfield_value.fieldtype'
            ])->orderBy('employee_id', 'DESC')->paginate($request->get('page_size'));

        return response()->json([
            'data' => [
                'results' => $results,
                'departmentList' => $departmentList,
                'designationList' => $designationList,
                'roleList' => $roleList
            ]
        ]);
    }

    public function printEmployee(Request $request)
    {
        $results = $this->repository->advancedSearch($request)->get();
        $printHead = PrintHeadSetting::first();

        return view('admin.employee.employee.print_employee', ['results' => $results, 'printHead' => $printHead]);
    }

    public function create()
    {
        $userList = User::where('status', 1)->get();
        $roleList = Role::get();
        $departmentList = Department::get();
        $designationList = Designation::get();
        $branchList = Branch::get();
        $workShiftList = WorkShift::get();
        $supervisorList = Employee::where('status', 1)->get();
        $payGradeList = PayGrade::all();
        $hourlyPayGradeList = HourlySalary::all();

        $data = [
            'userList' => $userList,
            'roleList' => $roleList,
            'departmentList' => $departmentList,
            'designationList' => $designationList,
            'branchList' => $branchList,
            'supervisorList' => $supervisorList,
            'workShiftList' => $workShiftList,
            'payGradeList' => $payGradeList,
            'hourlyPayGradeList' => $hourlyPayGradeList,
        ];

        return view('admin.employee.employee.addEmployee', $data);
    }

    public function store(EmployeeRequest $request)
    {
        $photo = $request->file('photo');

        if ($photo) {
            $imgName = md5(str_random(30) . time() . '_' . $request->file('photo')) . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move('uploads/employeePhoto/', $imgName);
            $employeePhoto['photo'] = $imgName;
        }

        $employeeDataFormat = $this->repository
            ->makeEmployeePersonalInformationDataFormat($request->all());

        if (isset($employeePhoto)) {
            $employeeData = $employeeDataFormat + $employeePhoto;
        } else {
            $employeeData = $employeeDataFormat;
        }

        try {
            DB::beginTransaction();

            $employeeAccountDataFormat = $this->repository->makeEmployeeAccountDataFormat($request->all());

            dd($employeeAccountDataFormat);

            $parentData = User::create($employeeAccountDataFormat);

            $employeeData['user_id'] = $parentData->user_id;
            $childData = Employee::create($employeeData);

            $employeeEducationData = $this->repository->makeEmployeeEducationDataFormat($request->all(), $childData->employee_id);
            if (count($employeeEducationData) > 0) {
                EmployeeEducationQualification::insert($employeeEducationData);
            }

            $employeeExperienceData = $this->repository->makeEmployeeExperienceDataFormat($request->all(), $childData->employee_id);
            if (count($employeeExperienceData) > 0) {
                EmployeeExperience::insert($employeeExperienceData);
            }

            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            return $e;
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return redirect('employee')->with('success', 'Employee information successfully saved.');
        } else {
            return redirect('employee')->with('error', 'Something Error Found !, Please try again.');
        }
    }

    public function edit($id)
    {
        $userList = User::where('status', 1)->get();
        $roleList = Role::get();
        $departmentList = Department::get();
        $designationList = Designation::get();
        $branchList = Branch::get();
        $supervisorList = Employee::where('status', 1)->get();
        $editModeData = Employee::findOrFail($id);
        $payGradeId = $editModeData->pay_grade_id;

        $workShiftList = WorkShift::get();
        $hourlyPayGradeList = HourlySalary::all();

        $employeeAccountEditModeData = User::where('user_id', $editModeData->user_id)->first();
        $educationQualificationEditModeData = EmployeeEducationQualification::where('employee_id', $id)->get();
        $experienceEditModeData = EmployeeExperience::where('employee_id', $id)->get();

        $data = [
            'userList' => $userList,
            'roleList' => $roleList,
            'departmentList' => $departmentList,
            'designationList' => $designationList,
            'branchList' => $branchList,
            'supervisorList' => $supervisorList,
            'workShiftList' => $workShiftList,
            'editModeData' => $editModeData,
            'employeeAccountEditModeData' => $employeeAccountEditModeData,
            'educationQualificationEditModeData' => $educationQualificationEditModeData,
            'experienceEditModeData' => $experienceEditModeData,
            'payGradeList' => PayGradeService::getPayGradeTypes('Monthly', true),
            'payGradeObject' => PayGrade::where('pay_grade_id', $editModeData->pay_grade_id)->first()->toArray()
        ];

        return view('admin.employee.employee.editEmployee', $data);
    }

    public function update(EmployeeRequest $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $photo = $request->file('photo');
        $requestPut = $request->all();

        if ($photo) {
            $imgName = md5(str_random(30) . time() . '_' . $request->file('photo')) . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move('uploads/employeePhoto/', $imgName);
            if (file_exists('uploads/employeePhoto/' . $employee->photo) and !empty($employee->photo)) {
                unlink('uploads/employeePhoto/' . $employee->photo);
            }
            $employeePhoto['photo'] = $imgName;
        }
        $employeeDataFormat = $this->repository->makeEmployeePersonalInformationDataFormat($request->all());
        if (isset($employeePhoto)) {
            $employeeData = $employeeDataFormat + $employeePhoto;
        } else {
            $employeeData = $employeeDataFormat;
        }

        try {
            DB::beginTransaction();

            $employeeAccountDataFormat = $this->repository->makeEmployeeAccountDataFormat($request->all(), 'update');
            User::where('user_id', $employee->user_id)->update($employeeAccountDataFormat);

            if (isset($requestPut['pay_grade_type_id']) && isset($requestPut['pay_grade_id'])) {
                PayGrade::where('pay_grade_id', $requestPut['pay_grade_id'])->update([
                    'pay_grade_type_id' => $requestPut['pay_grade_type_id']
                ]);
            }

            // Update Personal Information
            $employee->update($employeeData);

            // Delete education qualification
            EmployeeEducationQualification::whereIn('employee_education_qualification_id', explode(',', $request->delete_education_qualifications_cid))->delete();

            // Update Education Qualification
            $employeeEducationData = $this->repository->makeEmployeeEducationDataFormat($request->all(), $id, 'update');
            foreach ($employeeEducationData as $educationValue) {
                $cid = $educationValue['educationQualification_cid'];
                unset($educationValue['educationQualification_cid']);
                if ($cid != "") {
                    EmployeeEducationQualification::where('employee_education_qualification_id', $cid)->update($educationValue);
                } else {
                    $educationValue['employee_id'] = $id;
                    EmployeeEducationQualification::create($educationValue);
                }
            }

            // Delete experience
            EmployeeExperience::whereIn('employee_experience_id', explode(',', $request->delete_experiences_cid))->delete();

            // Update Education Qualification
            $employeeExperienceData = $this->repository->makeEmployeeExperienceDataFormat($request->all(), $id, 'update');
            if (count($employeeExperienceData) > 0) {
                foreach ($employeeExperienceData as $experienceValue) {
                    $cid = $experienceValue['employeeExperience_cid'];
                    unset($experienceValue['employeeExperience_cid']);
                    if ($cid != "") {
                        EmployeeExperience::where('employee_experience_id', $cid)->update($experienceValue);
                    } else {
                        $experienceValue['employee_id'] = $id;
                        EmployeeExperience::create($experienceValue);
                    }
                }
            }
            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return redirect()->back()->with('success', 'Employee information successfully updated.');
        } else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }

    public function show($id)
    {

        $employeeInfo = Employee::where('employee.employee_id', $id)->first();
        $employeeExperience = EmployeeExperience::where('employee_id', $id)->get();
        $employeeEducation = EmployeeEducationQualification::where('employee_id', $id)->get();

        return view('admin.user.user.profile', ['employeeInfo' => $employeeInfo, 'employeeExperience' => $employeeExperience, 'employeeEducation' => $employeeEducation]);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $data = Employee::FindOrFail($id);
            if (!is_null($data->photo)) {
                if (file_exists('uploads/employeePhoto/' . $data->photo) and !empty($data->photo)) {
                    unlink('uploads/employeePhoto/' . $data->photo);
                }
            }
            $result = $data->delete();
            if ($result) {
                DB::table('user')->where('user_id', $data->user_id)->delete();
                DB::table('employee_education_qualification')->where('employee_id', $data->employee_id)->delete();
                DB::table('employee_experience')->where('employee_id', $data->employee_id)->delete();
                DB::table('employee_attendance')->where('finger_print_id', $data->finger_id)->delete();
                DB::table('employee_award')->where('employee_id', $data->employee_id)->delete();
                DB::table('employee_bonus')->where('employee_id', $data->employee_id)->delete();
                DB::table('promotion')->where('employee_id', $data->employee_id)->delete();
                DB::table('salary_details')->where('employee_id', $data->employee_id)->delete();
                DB::table('training_info')->where('employee_id', $data->employee_id)->delete();
                DB::table('warning')->where('warning_to', $data->employee_id)->delete();
                DB::table('leave_application')->where('employee_id', $data->employee_id)->delete();
                DB::table('employee_performance')->where('employee_id', $data->employee_id)->delete();
                DB::table('termination')->where('terminate_to', $data->employee_id)->delete();
                DB::table('notice')->where('created_by', $data->employee_id)->delete();
            }
            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            return $e;
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            echo "success";
        } elseif ($bug == 1451) {
            echo 'hasForeignKey';
        } else {
            echo 'error';
        }
    }
}
