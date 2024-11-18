<?php

namespace App\Repositories;

use App\Model\EmployeeAttendance;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class AttendanceUploadRepository
{
    public function import($records)
    {
        // To support UTF - 8
        mb_internal_encoding('UTF-8');

        try {

            if (!$records) {
                throw new \Error("FILE_EMPTY");
            }

            DB::beginTransaction();

            $newTimeoutInOut = [];

            foreach ($records as $key => $row) {

                $fingerPrintId = intval(trim($row[0]));
                $date = trim($row[1]);

                $data = [
                    'finger_print_id' => $fingerPrintId,
                    'in_out_time' => $date
                ];

                $attendanceResult = EmployeeAttendance::where($data)->get();

                if ($attendanceResult->isEmpty()) {
                    $newTimeoutInOut[] = $data;
                }
            }

            if (count($newTimeoutInOut)) {
                EmployeeAttendance::insert($newTimeoutInOut);
            }

            DB::commit();

            $insertCount = count($newTimeoutInOut);
            $skippedCount = count($records) - $insertCount;

            return implode(", ",array_filter([
                $insertCount > 0 ? "Inserted $insertCount clocks" : null,
                $skippedCount > 0 ? "Skipped $skippedCount clocks" : null
            ]));
        } catch (QueryException $error) {
            DB::rollback();

            throw $error;
        }
        return null;
    }
}
