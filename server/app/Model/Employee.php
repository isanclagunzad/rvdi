<?php

namespace App\Model;

use App\Model\CustomField;
use App\Lib\Enumerations\UserStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\User;

class Employee extends BaseModel
{
    protected $table      = 'employee';
    protected $primaryKey = 'employee_id';
    protected $fillable   = [
        'employee_id', 'user_id', 'finger_id', 
        'department_id', 'designation_id', 'branch_id',
        'supervisor_id', 'work_shift_id', 'email',
        'first_name', 'last_name', 'date_of_birth',
        'date_of_joining', 'date_of_leaving', 'gender',
        'marital_status', 'photo', 'address',
        'emergency_contacts', 'phone', 'status',
        'created_by', 'updated_by', 'religion',
        'pay_grade_id', 'hourly_salaries_id', 'permanent_status',
        'middle_name', 'suffix', 'religion'
    ];

    const MALE = 'Male';
    const FEMALE = 'Female';

    public function getRouteKeyName()
    {
        return 'employee_id';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id')->withDefault([
            'department_id'   => 0,
            'department_name' => 'N/A',
        ]);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id')->withDefault([
            'designation_id'   => 0,
            'designation_name' => 'N/A',
        ]);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->withDefault([
            'branch_id'   => 0,
            'branch_name' => 'N/A',
        ]);
    }

    public function workshift()
    {
        return $this->hasOne(WorkShift::class, 'work_shift_id', 'work_shift_id');
    }

    public function payGrade()
    {
        return $this->belongsTo(PayGrade::class, 'pay_grade_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(Employee::class, 'supervisor_id');
    }

    public function attendance() 
    {
        return $this->hasMany(EmployeeAttendance::class, 'finger_print_id', 'finger_id');
    }

    public function customfield_value()
    {
        return $this->hasMany(CustomFieldValue::class, 'employee_id', 'employee_id');
        // return $this->belongsToMany(CustomField::class, 'employee_custom_fields', 'employee_id', 'custom_field_id');

        // return DB::table('employee_custom_fields')
        //     ->join(
        //         'custom_fields',
        //         'employee_custom_fields.custom_field_id', '=', 'custom_fields.id')
        //     ->join(
        //         'custom_field_values',
        //         'employee_custom_fields.id', '=', 'custom_field_values.employee_custom_field_id')
        //     ->join(
        //         'employee',
        //         'employee_custom_fields.employee_id', '=', 'employee.employee_id')
        //     ->select(
        //         'employee_custom_fields.employee_id',
        //         'employee_custom_fields.custom_field_id',
        //         'employee_custom_fields.created_at',
        //         'employee_custom_fields.updated_at',
        //         'employee.first_name',
        //         'employee.last_name',
        //         'employee.middle_name',
        //         'employee.suffix',
        //         'custom_fields.name as name',
        //         'custom_fields.uses_file as uses_file',
        //         'custom_field_values.id as custom_field_value_id',
        //         'custom_field_values.value as value'
        // );

        // return $this->belongsToMany(CustomField::class, 'employee_custom_fields', 'employee_id', 'custom_field_id')
        //             ->rightJoin('custom_field_values', 'custom_fields.id', '=', 'custom_field_values.custom_field_id')
        //             ->select(
        //                 'custom_fields.id as id',
        //                 'custom_fields.name as name',
        //                 'custom_fields.uses_file as uses_file',
        //                 'custom_field_values.id as value_id',
        //                 'custom_field_values.value as value'
        //             );

            // ->join('custom_field_values', 'employee_custom_fields.employee_id', '=', 'custom_field_values.employee_custom_field_id')
            // ->join('employee', 'employee_custom_fields.employee_id', '=', 'employee.employee_id')
            // ->select(
            //     'employee_custom_fields.employee_id',
            //     'employee_custom_fields.custom_field_id',
            //     'employee_custom_fields.created_at',
            //     'employee_custom_fields.updated_at',
            //     'employee.first_name',
            //     'employee.last_name',
            //     'employee.middle_name',
            //     'employee.suffix',
            //     'custom_fields.name as name',
            //     'custom_fields.uses_file as uses_file',
            //     'custom_field_values.id as custom_field_value_id',
            //     'custom_field_values.value as value'
            // );
    }

    public function hourlySalaries()
    {
        return $this->belongsTo(HourlySalary::class, 'hourly_salaries_id');
    }

    public function inOutData()
    {
        return $this->hasMany(EmployeeInOutdata::class, 'finger_print_id', 'finger_id');
    }

    public function scopeMales(Builder $query)
    {
        return $query->whereGender(Employee::MALE);
    }

    public function scopeFemales(Builder $query)
    {
        return $query->whereGender(Employee::FEMALE);
    }

    /**
     * Counts the employee per employment status
     * @param Builder $query 
     * @return Collection 
     */
    public function scopeCountProbationAndRegular(Builder $query) {
        return $query->whereStatus(UserStatus::$ACTIVE)
                    ->groupBy('permanent_status')
                    ->select('permanent_status', DB::raw('COUNT(employee.employee_id) as employee'))
                    ->get()
                    ->mapWithKeys(function($item) {
                        $status = $item->permanent_status == UserStatus::$PERMANENT ? 'Regular' : 'Probation';

                        return [
                            $status => $item->employees
                        ];
                    });
    }
}
