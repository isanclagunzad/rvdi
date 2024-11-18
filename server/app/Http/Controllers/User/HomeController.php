<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Mail as FacadesMail;
use App\Model\EmployeeEducationQualification;
use App\Repositories\AttendanceRepository;
use App\Http\Controllers\Controller;
use App\Model\Branch;
use App\Model\EmployeePerformance;
use Illuminate\Support\Facades\DB;
use App\Model\EmployeeExperience;
use App\Model\LeaveApplication;
use App\Model\EmployeeAward;
use App\Model\EmployeeAttendance;
use App\Model\Termination;
use App\Model\Department;
use App\Model\Designation;
use App\Model\Employee;
use App\Model\Warning;
use App\Model\Notice;
use App\Model\IpSetting;
use App\Model\Role;
use Carbon\Carbon;

class HomeController extends Controller
{

    protected $employeePerformance,
        $leaveApplication,
        $notice,
        $employeeExperience,
        $department,
        $employee,
        $employeeAward,
        $attendanceRepository,
        $warning,
        $termination,
        $branch,
        $designation,
        $role;

    function __construct(
        EmployeePerformance  $employeePerformance,
        LeaveApplication     $leaveApplication,
        Notice               $notice,
        EmployeeExperience   $employeeExperience,
        Department           $department,
        Employee             $employee,
        EmployeeAward        $employeeAward,
        AttendanceRepository $attendanceRepository,
        Warning              $warning,
        Termination          $termination,
        Role                 $role,
        Branch               $branch,
        Designation          $designation
    )
    {
        $this->employeePerformance = $employeePerformance;
        $this->leaveApplication = $leaveApplication;
        $this->notice = $notice;
        $this->employeeExperience = $employeeExperience;
        $this->department = $department;
        $this->employee = $employee;
        $this->employeeAward = $employeeAward;
        $this->attendanceRepository = $attendanceRepository;
        $this->warning = $warning;
        $this->termination = $termination;
        $this->role = $role;
        $this->branch = $branch;
        $this->designation = $designation;
    }


    public function index()
    {
        $ip_setting = IpSetting::orderBy('id', 'desc')->first();
        $ip_attendance_status = 0;
        $ip_check_status = 0;
        $login_employee = employeeInfo();
        $count_user_login_today =
            EmployeeAttendance::where('finger_print_id', '=', $login_employee[0]->finger_id)
                ->whereDate('in_out_time', '=', date('Y-m-d'))
                ->count();

        $employeeCategorisationCounter = null;
        if(auth()->user()->can('see-employee-categorisation')) {
            $employeeCategorisationCounter = [
                'gender' => [
                    'males' => $this->employee->males()->count(),
                    'females' => $this->employee->females()->count()
                ],
                'role' => $this->role->employees()->all(),
                'department' => $this->department->employees()->all(),
                'branch' => $this->branch->employees()->all(),
                'designation' => $this->designation->employees()->all(),
                'employmentStatus' => $this->employee->countProbationAndRegular()->all()
            ];
        }
        

        if ($ip_setting) {
            // if 0 then attendance will not take
            $ip_attendance_status = $ip_setting->status;
            // if 0 then ip will not checked for attendance
            $ip_check_status = $ip_setting->ip_status;
        }

        // WIP Monthly Attendance graph's logic is the same as this one below
        // $attendanceData = $this->attendanceRepository
        //     ->getEmployeeMonthlyAttendance(
        //         date("Y-m-01"),
        //         date("Y-m-d"),
        //         session('logged_session_data.employee_id')
        //     );

        // WIP change this code to implement permission
        // if (session('logged_session_data.role_id') != 1) {
        //     $employeePerformance = $this->employeePerformance
        //         ->select('employee_performance.*', DB::raw('AVG(employee_performance_details.rating) as rating'))
        //         ->with(['employee' => function ($d) {
        //             $d->with('department');
        //         }])
        //         ->join(
        //             'employee_performance_details',
        //             'employee_performance_details.employee_performance_id',
        //             '=',
        //             'employee_performance.employee_performance_id'
        //         )
        //         ->where('month', function ($query) {
        //             $query->select(DB::raw('MAX(`month`) AS month'))->from('employee_performance');
        //         })->where('employee_performance.status', 1)->groupBy('employee_id')->get();

        //     $employeeTotalAward = $this->employeeAward
        //         ->select(DB::raw('count(*) as totalAward'))
        //         ->where('employee_id', session('logged_session_data.employee_id'))
        //         ->whereBetween('month', [date("Y-01"), date("Y-12")])
        //         ->first();

        //     $notice = $this->notice->with('createdBy')->orderBy('notice_id', 'DESC')->where('status', 'Published')->get();
        //     $terminationData = $this->termination->with('terminateBy')->where('terminate_to', session('logged_session_data.employee_id'))->first();

        //     $hasSupervisorWiseEmployee =
        //         $this->employee
        //             ->select('employee_id')
        //             ->where('supervisor_id', session('logged_session_data.employee_id'))
        //             ->get()
        //             ->toArray();
        //     if (count($hasSupervisorWiseEmployee) == 0) {
        //         $leaveApplication = [];
        //     } else {
        //         $leaveApplication = $this->leaveApplication->with(['employee', 'leaveType'])
        //             ->whereIn('employee_id', array_values($hasSupervisorWiseEmployee))
        //             ->where('status', 1)
        //             ->orderBy('status', 'asc')
        //             ->orderBy('leave_application_id', 'desc')
        //             ->get();
        //     }

        //     $employeeInfo = $this->employee->with('designation')->where('employee_id', session('logged_session_data.employee_id'))->first();
        //     $employeeTotalLeave = $this->leaveApplication->select(DB::raw('IFNULL(SUM(number_of_day), 0) as totalNumberOfDays'))
        //         ->where('employee_id', session('logged_session_data.employee_id'))
        //         ->where('status', 2)
        //         ->whereBetween('approve_date', [date("Y-01-01"), date("Y-12-31")])
        //         ->first();

        //     $warning = $this->warning->with(['warningBy'])->where('warning_to', session('logged_session_data.employee_id'))->get();

        //     // date of birth in this month 
        //     $firstDayThisMonth = date('Y-m-01');
        //     $lastDayThisMonth = date('Y-m-t');

        //     $from_date_explode = explode('-', $firstDayThisMonth);
        //     $from_day = $from_date_explode[2];
        //     $from_month = $from_date_explode[1];
        //     $concatFormDayAndMonth = $from_month . '-' . $from_day;

        //     $to_date_explode = explode('-', $lastDayThisMonth);
        //     $to_day = $to_date_explode[2];
        //     $to_month = $to_date_explode[1];
        //     $concatToDayAndMonth = $to_month . '-' . $to_day;

        //     $upcoming_birthday =
        //         Employee::orderBy('date_of_birth', 'desc')
        //             ->whereRaw(
        //                 "DATE_FORMAT(date_of_birth, '%m-%d') >= '" . $concatFormDayAndMonth .
        //                 "' AND DATE_FORMAT(date_of_birth, '%m-%d') <= '" . $concatToDayAndMonth . "' "
        //             )->get();

        //     return view('admin.generalUserHome', compact(
        //         'attendanceData',
        //         'employeePerformance',
        //         'employeeTotalAward',
        //         'notice',
        //         'leaveApplication',
        //         'employeeInfo',
        //         'employeeTotalLeave',
        //         'warning',
        //         'terminationData',
        //         'upcoming_birthday',
        //         'ip_attendance_status',
        //         'ip_check_status',
        //         'count_user_login_today',
        //     ));
        // }

        $hasSupervisorWiseEmployee = $this->employee
            ->select('employee_id')
            ->where('supervisor_id', session('logged_session_data.employee_id'))
            ->get()
            ->toArray();

        if (count($hasSupervisorWiseEmployee) == 0) {
            $leaveApplication = [];
        } else {
            $leaveApplication = $this->leaveApplication->with(['employee', 'leaveType'])
                ->whereIn('employee_id', array_values($hasSupervisorWiseEmployee))
                ->where('status', 1)
                ->orderBy('status', 'asc')
                ->orderBy('leave_application_id', 'desc')
                ->get();
        }

        $date = date('Y-m-d');

        $totalEmployee = $this->employee->where('status', 1)->count();
        $totalDepartment = $this->department->count();

        $employeePerformance = null;
        if(auth()->user()->can('see-employee-performance')) {
            $employeePerformance = $this->employeePerformance
                ->select('employee_performance.*', DB::raw('AVG(employee_performance_details.rating) as rating'))
                ->with(['employee' => function ($d) {
                    $d->with('department');
                }])->join(
                    'employee_performance_details', 
                    'employee_performance_details.employee_performance_id', 
                    '=', 
                    'employee_performance.employee_performance_id'
                )->where('month', function ($query) {
                    $query->select(DB::raw('MAX(`month`) AS month'))->from('employee_performance');
                })->where('employee_performance.status', 1)->groupBy('employee_id')->get();
        }

        $employeeAward = null;
        if(auth()->user()->can('see-employee-award')) {
            $employeeAward = $this->employeeAward->with(['employee' => function ($d) {
                $d->with('department');
            }])->limit(10)->orderBy('employee_award_id', 'DESC')->get();
        }

        $notice = $this->notice->with('createdBy')->orderBy('notice_id', 'DESC')->where('status', 'Published')->get();

        // date of birth in this month

        $firstDayThisMonth = date('Y-m-01');
        $lastDayThisMonth = date('Y-m-t');

        $from_date_explode = explode('-', $firstDayThisMonth);
        $from_day = $from_date_explode[2];
        $from_month = $from_date_explode[1];
        $concatFormDayAndMonth = $from_month . '-' . $from_day;

        $to_date_explode = explode('-', $lastDayThisMonth);
        $to_day = $to_date_explode[2];
        $to_month = $to_date_explode[1];
        $concatToDayAndMonth = $to_month . '-' . $to_day;
 
        $upcoming_birthday = null;
        if(auth()->user()->can('see-upcoming-birthday')) {
            $upcoming_birthday = Employee::orderBy('date_of_birth', 'desc')
                ->whereRaw(
                    "DATE_FORMAT(date_of_birth, '%m-%d') >= '" . $concatFormDayAndMonth .
                    "' AND DATE_FORMAT(date_of_birth, '%m-%d') <= '" . $concatToDayAndMonth . "' ")
                ->get();
        }
        
        $totalAttendance = null;
        $totalAbsent = null;
        if(auth()->user()->can('see-attendance-total')) {
            $attendanceData = DB::select("call `SP_DailyAttendance`('" . $date . "')");
            $totalAttendance = count($attendanceData);
            $totalAbsent = $totalEmployee ? $totalEmployee - count($attendanceData) : null;
        }

        $between_dates_attendance = null;
        if(auth()->user()->can('see-between-dates-attendance')) {
            $between_dates_attendance = $this->attendanceRepository->getAttendanceFromBetweenDates(
                Carbon::today()->subMonth()->format('Y-m-d'),
                Carbon::yesterday()->format('Y-m-d'),
            );
            $between_dates_attendance = json_encode($between_dates_attendance);
        }

        return view('admin.adminhome', compact( 
            'attendanceData',
            'totalEmployee',
            'totalDepartment',
            'totalAttendance',
            'totalAbsent',
            'employeePerformance',
            'employeeAward',
            'notice',
            'leaveApplication',
            'upcoming_birthday',
            'ip_attendance_status',
            'ip_check_status',
            'count_user_login_today',
            'between_dates_attendance',
            'employeeCategorisationCounter'
        ));
    }


    public function profile()
    {
        $employeeInfo = Employee::where('employee.employee_id', session('logged_session_data.employee_id'))->first();
        $employeeExperience = EmployeeExperience::where('employee_id', session('logged_session_data.employee_id'))->get();
        $employeeEducation = EmployeeEducationQualification::where('employee_id', session('logged_session_data.employee_id'))->get();

        return view(
            'admin.user.user.profile',
            ['employeeInfo' => $employeeInfo, 'employeeExperience' => $employeeExperience, 'employeeEducation' => $employeeEducation]
        );
    }


    public function mail()
    {

        $user = array(
            'name' => "Learning Laravel",
        );

        FacadesMail::send('emails.mailExample', $user, function ($message) {
            $message->to("kamrultouhidsak@gmail.com");
            $message->subject('E-Mail Example');
        });

        return "Your email has been sent successfully";
    }
}
