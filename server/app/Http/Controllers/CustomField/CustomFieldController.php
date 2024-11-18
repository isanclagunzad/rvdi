<?php

namespace App\Http\Controllers\CustomField;

use App\Http\Requests\CustomFieldRequest;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Model\CustomField;
use App\Model\CustomFieldValue;
use App\Model\Employee;
use Illuminate\Auth\Access\AuthorizationException;

class CustomFieldController extends Controller
{
    public function index()
    {
        $this->authorize('access-custom-fields');

        return response()->json([
            'data' => CustomField::all()
        ]);
    }

    public function listByEmployee($employeeId)
    {
        $this->authorize('access-custom-fields');

        $employeeCustomFields = Employee::with('customfield_value.fieldtype')->whereEmployeeId($employeeId)->first();

        return response()->json([
            'data' => $employeeCustomFields
        ]);
    }

    public function store(CustomFieldRequest $request, Employee $employee) 
    {
        $this->authorize('access-custom-fields');

        $hasFile = false;
        $path = null;

        try {
            if($request->hasFile('file')) {
                $path = $request->file('file')->store('files');
                $hasFile = true;
            }

            DB::beginTransaction();

            $customField = CustomField::updateOrCreate([
                'name' => $request->get('name'),
                'uses_file' => $hasFile
            ]);

            CustomFieldValue::create([
                'value' => $hasFile ? $path : $request->get('value'),
                'custom_field_id' => $customField->id,
                'employee_id' => $employee->employee_id
            ]);

            DB::commit();

            return response()->json([
                'data' => [],
                'message' => 'Custom field successfully added!'
            ]);
        } catch (QueryException $exception) {
            DB::rollback();

            throw $exception;
        }
    }

    public function update(CustomFieldRequest $request, Employee $employee, CustomFieldValue $customFieldValue) 
    {
        $this->authorize('access-custom-fields');

        if($employee->employee_id != $customFieldValue->employee_id) {
            throw new AuthorizationException('Unauthorized');
        }

        $customField = $customFieldValue->fieldtype;

        if($customField->uses_file && !$request->hasFile('file')) {
            return response()->json([
                'message' => 'file field is required',
            ], 422);
        }

        if($customField->uses_file && $request->hasFile('file')) {
            $path = $request->file('file')->store('files');
            
            $customFieldValue->update([
                'value' => $path
            ]);
        } else { 
            $customFieldValue->update([
                'value' => $request->input('value')
            ]);
        }

        return response()->json([
            'message' => 'Update successful'
        ]);
    }

    public function delete(Employee $employee, CustomFieldValue $customFieldValue) 
    {
        $this->authorize('access-custom-fields');

        if($employee->employee_id != $customFieldValue->employee_id) {
            throw new AuthorizationException('Unauthorized');
        }

        $customFieldValue->delete();

        return response()->json([
            'message' => 'Successfully removed field value'
        ]);
    }

    public function serveFile($customFieldId, $fieldValueId) 
    {
        $customFieldValue = CustomFieldValue::whereId($fieldValueId)->whereCustomFieldId($customFieldId)->first();
        $filePath = storage_path('app' . DIRECTORY_SEPARATOR . $customFieldValue->value);

        if(!file_exists($filePath)) {
            throw new NotFoundHttpException('File not found.');
        }

        $contentType = $this->getContentType($customFieldValue->value);
            
        return response()->stream(function() use ($filePath) {
            readfile($filePath);
        }, 200, [ 'Content-Type' => $contentType ]);
    }

    private function getContentType($fileName)
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        switch ($extension) {
            case 'pdf':
                return 'application/pdf';
            case 'jpg':
            case 'jpeg':
                return 'image/jpeg';
            case 'png':
                return 'image/png';
            case 'txt':
                return 'text/plain';

            // Add more cases for other file types as needed
            default:
                return 'application/octet-stream'; // Fallback
        }
    }
}
