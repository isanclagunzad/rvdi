<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceUploadRequest;
use App\Repositories\AttendanceUploadRepository;
use App\Services\TsvReaderService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class UploadAttendanceController extends Controller
{

    protected $tsvReader;
    protected $repository;

    public function __construct(TsvReaderService $tsvReader, AttendanceUploadRepository $repository)
    {
        $this->tsvReader = $tsvReader;
        $this->repository = $repository;
    }

    public function index()
    {
        return view('admin.attendance.manualAttendance.bulk_upload');
    }

    public function store(AttendanceUploadRequest $request)
    {
        try {
            $data = $this->tsvReader->read($request->file('file')->path());

            $message = $this->repository->import($data);

            return redirect()->back()
                ->with('success', !!$message ? $message : 'Bulk upload employee successful.');
        } catch (QueryException $error) {
            Log::error($error->getMessage());

            return redirect()->back()
                ->with('error', 'An error occurred while importing. Please try again.');
        }
    }

    public function apiStore(AttendanceUploadRequest $request)
    {
        try {
            $data = $this->tsvReader->read($request->file('file')->path());

            $message = $this->repository->import($data);

            return response()->json(['success' => !!$message ? $message : 'Bulk upload employee successful.'], 200);
        } catch (QueryException $error) {
            Log::error($error->getMessage());

            return response()->json(['error' => 'An error occurred while importing. Please try again.'], 404);
        }
    }

}
