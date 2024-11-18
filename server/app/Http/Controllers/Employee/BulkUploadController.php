<?php

namespace App\Http\Controllers\Employee;

use App\Exceptions\DuplicateEmployeeIdException;
use App\Exceptions\DuplicateUsernameException;
use App\Model\PayGrade;
use App\Services\PayGradeService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\EmployeeUploadRequest;
use App\Http\Controllers\Controller;
use App\Services\CsvReaderService;

use App\Repositories\EmployeeBulkUploadRepository;
use Error;

class BulkUploadController extends Controller
{
    protected $csvReader;
    protected $repository;

    public function __construct(CsvReaderService $service, EmployeeBulkUploadRepository $repository)
    {
        $this->csvReader = $service;
        $this->repository = $repository;
    }

    public function index()
    {
        return view('admin.employee.employee.bulk_upload');
    }

    public function biometric()
    {
        return view('admin.employee.employee.bulk_upload');
    }

    public function store(EmployeeUploadRequest $request)
    {

        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '200');
        ini_set('upload_max_filesize', '100M');
        ini_set('post_max_size', '100M');

        $this->authorize('manage-employee');

        try {
            $data = $this->csvReader->readCSV($request->file('file')->path());

            $this->repository->createEmployeeRecordViaCsv($data);

            if(request()->wantsJson()) {
                return response()->json([
                    'data' => null,
                    'message' => 'Bulk employee upload successful!'
                ]);
            }

            return redirect()->back()->with('success', 'Bulk upload employee successful!');
        } catch (QueryException $error) {
            Log::error($error->getMessage());

            if(request()->wantsJson()) {
                return response()->json([
                    'data' => null,
                    'message' => 'An error occurred while importing. Please try again.'
                ], 422);
            }

            return redirect()->back()
                            ->with('error', 'An error occurred while importing. Please try again.');
        } catch (DuplicateUsernameException $error) {
            Log::error($error->getMessage());

            if(request()->wantsJson()) {
                return response()->json([
                    'data' => null,
                    'message' => $error->getMessage()
                ], 422);
            }

            return redirect()->back()->with('error', $error->getMessage());
        } catch (DuplicateEmployeeIdException $error) {
            Log::error($error->getMessage());

            if(request()->wantsJson()) {
                return response()->json([
                    'data' => null,
                    'message' => $error->getMessage()
                ], 422);
            }

            return redirect()->back()->with('error', $error->getMessage());
        } catch (Error $error) {
            Log::error($error->getMessage());

            if(request()->wantsJson()) {
                return response()->json([
                    'data' => null,
                    'message' => 'An error occurred while importing. Please try again.'
                ], 422);
            }

            return redirect()->back()
                            ->with('error', 'An error occurred while importing. Please try again.');
        }
    }
}
