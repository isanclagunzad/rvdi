<?php

use Illuminate\Database\Migrations\Migration;

class CreateInBetweenDatesAttendance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS SP_attendanceForGivenDates');
        DB::unprepared("
            CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_attendanceForGivenDates`(
                IN from_date DATE,
                IN to_date DATE
            )
            BEGIN
                SELECT DATE(`date`) AS attendance_date, COUNT(*) AS number_of_attendees
                FROM view_employee_in_out_data
                WHERE `date` BETWEEN from_date AND to_date
                AND `working_time` >= '08:00:00'
                GROUP BY DATE(`date`);
            END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS SP_attendanceForGivenDates');
    }
}
