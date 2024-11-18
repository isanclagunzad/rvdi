<?php

namespace App\Repositories;

use App\Model\{Allowance, Deduction, Department, Designation, Employee, Branch, CustomField, CustomFieldValue, PayGrade, Role, WorkShift};
use App\Exceptions\DuplicateEmployeeIdException;
use App\Exceptions\DuplicateUsernameException;
use App\Lib\Enumerations\EmploymentStatus;
use App\Services\PayGradeService;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{DB, Hash, Log};
use Illuminate\Support\Str;
use voku\helper\UTF8;

class EmployeeBulkUploadRepository
{
    protected const CSV_FIELD_MAPS = [
        'employee_id' => 'Employee number',
        'first_name' => 'First name',
        'middle_name' => 'Middle name',
        'last_name' => 'Last name',
        'suffix' => 'Suffix',
        'date_of_birth' => 'Birthdate',
        'gender' => 'Gender',
        'marital_status' => 'Civil status',
        'phone' => 'Mobile number',
        'email' => 'Email address',
        'address' => 'Address',
        'status' => 'Employment status',
        'date_of_joining' => 'Date hired',
        'role_id' => 'Role',
        'designation_id' => 'Position',
        'department_id' => 'Organizational unit',
        'pay_grade_id' => 'Basic salary',
        'branch_id' => 'Department branch',
        'date_of_leaving' => 'Date of leaving',
        'date_of_clearance' => 'Date of clearance',
        'user_name' => 'Username',
        'password' => 'Password',
        'finger_id' => 'Fingerprint id',
        'deduction' => 'Deductions',
        'allowance' => 'Allowances',
        'work_shift_id' => 'Work shift',
        'supervisor_id' => 'Supervisor'
    ];

    protected const ALLOWED_ATTACHMENTS = [
        'Allowance' => Allowance::class,
        'Deduction' => Deduction::class,
    ];

    protected $PAY_GRADE_TYPE = [
        '0' => 'No Pay'
    ];

    public function createEmployeeRecordViaCsv($rawData)
    {
        $records = $rawData;
        $extractedColumns = array_shift($records);
        $data = $this->combineExtractedColumnsToData($extractedColumns, $records);

        try {
            $this->checkForDuplicates($data);

            DB::transaction(function () use ($data) {
                $employeeCompanyDetailsList = $this->getMissingEmployeeDetails($data);
                $this->generateEmployeeAccountRecords($data, $employeeCompanyDetailsList['roles']);
                $this->generateEmployeeRecords($data, $employeeCompanyDetailsList);
            });
        } catch (QueryException $error) {
            throw $error;
        }
    }

    protected function checkForDuplicates($data)
    {
        $this->checkForDuplicateInFile('Username', $data);
        $this->checkForDuplicateInFile('Employee number', $data);
        $this->checkForDuplicateUsernameInDatabase($data);
    }

    protected function checkForDuplicateInFile($column, $data)
    {
        $collection = collect($data)->pluck($column);
        $duplicates = $collection->filter(function ($value) use ($collection, $column) {
            return $collection->where($column, $value)->count() > 1;
        })->unique()->values()->all();

        if (count($duplicates) > 0) {
            $exceptionClass = $column === 'Employee number' ? DuplicateEmployeeIdException::class : DuplicateUsernameException::class;
            throw new $exceptionClass(implode(', ', $duplicates));
        }
    }

    protected function checkForDuplicateUsernameInDatabase($data)
    {
        $userNamesList = collect($data)->map(function ($row) {
            return $this->getUsernameForRow($row);
        })->filter()->all();

        $existingUsers = User::whereIn('user_name', $userNamesList)->get();

        $duplicates = $existingUsers->filter(function ($user) use ($data) {
            $matchingRow = collect($data)->first(function ($value) use ($user) {
                return $value['Username'] == $user->user_name;
            });
            return $matchingRow && $matchingRow['Employee number'] != $user->employee->employee_id;
        })->pluck('user_name');

        if ($duplicates->isNotEmpty()) {
            throw new DuplicateUsernameException($duplicates->implode(', '));
        }
    }

    protected function getUsernameForRow($row)
    {
        return empty($row['Username']) ?
            $this->generateUserName($row['Last name'] . ' ' . $row['First name']) :
            $row['Username'];
    }

    protected function combineExtractedColumnsToData($extractedColumns, $records)
    {
        return array_map(function ($values) use ($extractedColumns) {
            return array_combine($extractedColumns, $values);
        }, $records);
    }

    protected function getMissingEmployeeDetails($csvData)
    {
        $collection = collect($csvData);

        return [
            'branches' => $this->generateMissingCompanyDetail($collection, 'Department branch', Branch::class),
            'roles' => $this->generateMissingCompanyDetail($collection, 'Role', Role::class),
            'allowances' => $this->generateMissingCompanyDetail($collection, 'Allowances', Allowance::class, true),
            'deductions' => $this->generateMissingCompanyDetail($collection, 'Deductions', Deduction::class, true),
            'work_shifts' => $this->generateMissingCompanyDetail($collection, 'Work shift', WorkShift::class, false, 'shift_name'),
            'departments' => $this->generateMissingCompanyDetail($collection, 'Organizational unit', Department::class),
            'positions' => $this->generateMissingCompanyDetail($collection, 'Position', Designation::class),
            'custom_fields' => $this->generateMissingCustomFields($collection)
        ];
    }

    protected function generateMissingCompanyDetail($collection, $fieldName, $model, $explodeAndTrim = false, $customNameField = null)
    {
        $details = $this->getEmployeeCompanyDetail($collection, $fieldName, $explodeAndTrim);
        $modelName = class_basename($model);
        $field = Str::snake($modelName);
        $fieldId = $field . '_id';
        $fieldName = $customNameField ?? ($field . '_name');

        $results = [];
        foreach ($details as $detail) {
            $record = $model::updateOrCreate([$fieldName => $detail]);
            $results[$detail] = $record->$fieldId;
        }

        return $results;
    }

    protected function getEmployeeCompanyDetail($collection, $filter, $explodeAndTrimEachRow = false)
    {
        return $collection->flatMap(function ($item) use ($filter, $explodeAndTrimEachRow) {
            $value = $item[$filter];
            if (!$explodeAndTrimEachRow) {
                return [$value];
            }
            return collect(explode(',', $value))->map(function ($item) {
                return trim($item);
            });
        })->unique()->values()->all();
    }

    /**
     * Generate missing custom fields based on CSV headers with "Custom:" prefix
     *
     * @param \Illuminate\Support\Collection $collection
     * @return void
     */
    function generateMissingCustomFields(Collection $collection)
    {
        // Filter and process CSV headers to find custom fields
        $customFields = $collection->flatMap(function ($item) {
            return $item;
        })->filter(function ($value, $key) {
            return starts_with($key, 'Custom:');
        })->map(function ($value, $key) {
            return str_after($key, 'Custom:');
        });

        $customFieldResult = [];

        // Create missing custom fields
        foreach ($customFields as $field) {
            $customField = CustomField::updateOrCreate(
                [
                    'name' => $field,
                ],
                [
                    'name' => $field,
                ]
            );

            $customFieldResult[$field] = $customField->id;
        }

        return $customFieldResult;
    }

    protected function generateEmployeeAccountRecords($data, $rolesMap)
    {
        foreach ($data as $row) {
            $userName = $this->getUsernameForRow($row);

            User::updateOrCreate(
                ['user_name' => $userName],
                [
                    'role_id' => $rolesMap[$row['Role']],
                    'password' => Hash::make($row['Password'] ?? $userName),
                    'status' => $this->determineUserStatus($row),
                    'created_by' => auth()->id() ?? 0,
                    'updated_by' => auth()->id() ?? 0,
                ]
            );
        }
    }

    protected function determineUserStatus($row)
    {
        return empty($row['Date of leaving']) ||
            empty($row['Date of clearance']) ||
            in_array($row['Employment status'], ['Probation', 'Regular']) ? 1 : 0;
    }

    protected function generateEmployeeRecords($data, $otherEmployeeDetail)
    {
        foreach ($data as $row) {
            Employee::updateOrCreate(
                ['employee_id' => $row['Employee number']],
                $this->generateEmployeeData($row, $otherEmployeeDetail)
            );
            $this->attachCustomFields($row, $otherEmployeeDetail);
        }
    }

    protected function generateEmployeeData($individualEmployeeData, $otherEmployeeDetails)
    {
        $userName = $this->getUsernameForRow($individualEmployeeData);

        $payGradeId = $this->generatePayGrade(
            $individualEmployeeData['First name'],
            $individualEmployeeData['Last name'],
            $individualEmployeeData['Basic salary'],
            $individualEmployeeData['Pay Grade Type']
        );

        $this->attachAllowancesAndDeductions($payGradeId, $individualEmployeeData, $otherEmployeeDetails);

        $employeeData = [];

        foreach (self::CSV_FIELD_MAPS as $dbField => $csvField) {
            $employeeData[$dbField] = $this->formatFieldValue($dbField, $individualEmployeeData[$csvField], $otherEmployeeDetails);
        }

        $employeeData['pay_grade_id'] = $payGradeId;
        $employeeData['permanent_status'] = $this->getEmploymentStatus($individualEmployeeData['Employment status']);
        $employeeData['created_by'] = $employeeData['updated_by'] = auth()->id() ?? 0;
        $employeeData['user_id'] = User::where('user_name', $userName)->first()->user_id;

        return $employeeData;
    }

    protected function formatFieldValue($field, $value, $otherEmployeeDetails)
    {
        switch ($field) {
            case 'first_name':
            case 'middle_name':
            case 'last_name':
            case 'suffix':
                return $value ? ucfirst(UTF8::strtolower($value)) : null;
            case 'date_of_joining':
            case 'date_of_leaving':
            case 'date_of_clearance':
                return $value ? dateConvertFormtoDB($value) : null;
            case 'designation_id':
                return $otherEmployeeDetails['positions'][$value] ?? null;
            case 'department_id':
                return $otherEmployeeDetails['departments'][$value] ?? null;
            case 'branch_id':
                return $otherEmployeeDetails['branches'][$value] ?? null;
            case 'work_shift_id':
                return $otherEmployeeDetails['work_shifts'][$value] ?? null;
            case 'finger_id':
                return $value;
            case 'status':
                return $this->determineUserStatus($otherEmployeeDetails);
            case 'email':
                return $value ?: null;
            default:
                return $value;
        }
    }

    protected function attachAllowancesAndDeductions($payGradeId, $employeeData, $otherEmployeeDetails)
    {
        $payGrade = PayGrade::find($payGradeId);

        $this->attachBaseAllowancesAndDeductions($payGrade, 'allowances', $employeeData['Allowances'], $otherEmployeeDetails['allowances']);
        $this->attachBaseAllowancesAndDeductions($payGrade, 'deductions', $employeeData['Deductions'], $otherEmployeeDetails['deductions']);
        $this->attachMiscellaneous($payGrade, $employeeData);
    }

    protected function attachBaseAllowancesAndDeductions($payGrade, $relation, $items, $idMap)
    {
        $itemList = collect(explode(',', $items))->map(function ($item) {
            return trim($item);
        });

        foreach ($itemList as $item) {
            if (empty($item))
                continue;

            $relatedTable = $payGrade->$relation()->getRelated()->getTable();
            $payGrade->$relation()->updateOrCreate(
                [
                    $relatedTable . '.' . $relatedTable . '_id' => $idMap[$item]
                ],
                [
                    $relatedTable . '_name' => $item
                ]
            );
        }
    }

    public function attachMiscellaneous($payGrade, $employeeData)
    {
        $filteredItems = array_filter($employeeData, function ($index, $item) {
            return strpos($item, ':') !== false;
        }, ARRAY_FILTER_USE_BOTH);

        foreach ($filteredItems as $key => $value) {
            list($model, $attachmentNameValue) = explode(':', $key);

            if (!in_array($model, array_keys(self::ALLOWED_ATTACHMENTS))) {
                continue;
            }

            $model = self::ALLOWED_ATTACHMENTS[$model];
            $modelDir = explode('\\', $model);
            $baseName = strtolower(end($modelDir));

            $attachmentName = $baseName . '_name';
            $attachmentType = $baseName . '_type';
            $relation = $baseName . 's';

            $payGrade->$relation()->updateOrCreate(
                [
                    $attachmentName => $attachmentNameValue,
                ],
                [
                    $attachmentType => 'Fixed',
                    'percentage_of_basic' => 0,
                    'limit_per_month' => $value,
                    $attachmentName => $attachmentNameValue,
                ]
            );
        }
    }

    public function attachCustomFields($employeeData, $otherEmployeeDetails)
    {
        $employeeId = $employeeData['Employee number'];

        $customFieldValueKeyMap = $otherEmployeeDetails['custom_fields'];
        $employeeData = collect($employeeData)->filter(function ($value, $key) {
            return starts_with($key, 'Custom:');
        })->map(function ($value, $key) {
            return [
                'name' => str_after($key, 'Custom:'),
                'value' => $value
            ];
        });

        foreach ($employeeData as $key => $data) {
            CustomFieldValue::updateOrCreate(
                [
                    'custom_field_id' => $customFieldValueKeyMap[$data['name']],
                    'employee_id' => $employeeId
                ],
                [
                    'value' => $data['value'],
                    'custom_field_id' => $customFieldValueKeyMap[$data['name']],
                    'employee_id' => $employeeId
                ]
            );
        }
    }

    public function generatePayGrade($firstName, $lastName, $basicSalary, $payGradeTypeText)
    {
        $basicSalary = str_replace(',', '', $basicSalary);
        $payGradeTypeId = PayGradeService::getPayGradeTypeId($payGradeTypeText);
        $payGradeName = ucfirst(UTF8::strtolower($firstName)) . ' ' . ucfirst(UTF8::strtolower($lastName));

        Log::info("Pay Grade, $payGradeTypeText, $payGradeTypeId");

        $model = PayGrade::updateOrCreate(
            [   'pay_grade_name' => $payGradeName   ],
            [
                'gross_salary' => floatval($basicSalary),
                'percentage_of_basic' => 100,
                'basic_salary' => floatval($basicSalary),
                'pay_grade_type_id' => $payGradeTypeId,
                'pay_grade_name' => $payGradeName
            ]
        );

        Log::info("Paygrade: ".$model->fresh()->__toString());

        return $model->fresh()->pay_grade_id;
    }

    protected function getEmploymentStatus($status)
    {
        switch ($status) {
            case 'Probationary':
            case 'Probation period':
                return EmploymentStatus::$PROBATION_PERIOD;
            case 'Terminated':
                return EmploymentStatus::$TERMINATED;
            case 'Resigned':
                return EmploymentStatus::$RESIGNED;
            case 'Finished Contract':
                return EmploymentStatus::$FINISHED_CONTRACT;
            default:
                return EmploymentStatus::$REGULAR;
        }
    }

    public function generateUserName($name)
    {
        return UTF8::strtolower(implode('.', explode(' ', $name)));
    }
}
