<?php

namespace App\Http\Controllers;

use App\Model\EmployeeAttendance;
use App\Model\EmployeeInOutdata;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeAttendanceController extends Controller
{
    public function destroy($attendanceId, $fingerPrintId)
    {
        $code = null;

        try {
            DB::beginTransaction();
            $inOutData = EmployeeInOutdata::whereEmployeeAttendanceId($attendanceId)->first();
            EmployeeAttendance::whereFingerPrintId($fingerPrintId)->whereBetween('in_out_time', [$inOutData->in_time, $inOutData->out_time])->delete();
            DB::commit();
            $code = 0;
        } catch (Exception $exception) {
            DB::rollback();
            Log::error($exception);
            $code = $exception->getCode();
        }

        if ($code == 0) {
            echo "success";
        } elseif ($code > 0) {
            echo 'hasForeignKey';
        } else {
            echo 'error';
        }
    }
}
