<?php

use Illuminate\Database\Seeder;
use App\Constants\ModuleConstants;

include_once 'MenuHelper.php';

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $ADMINISTRATION = ModuleConstants::ADMINISTRATION;
        $EMPLOYEES = ModuleConstants::EMPLOYEES;
        $LEAVES = ModuleConstants::LEAVES;
        $ATTENDANCE = ModuleConstants::ATTENDANCE;
        $PAYROLL = ModuleConstants::PAYROLL;
        $PERFORMANCE = ModuleConstants::PERFORMANCE;
        $RECRUITMENT = ModuleConstants::RECRUITMENT;
        $TRAINING = ModuleConstants::TRAINING;
        $AWARD = ModuleConstants::AWARD;
        $NOTICE = ModuleConstants::NOTICE_BOARD;
        $SETTINGS = ModuleConstants::SETTINGS;

        DB::table('menus')->truncate();
        DB::insert("INSERT INTO `menus` (`id`, `parent_id`, `action`, `name`, `menu_url`, `module_id`, `status`) VALUES
        
        (1, 0, NULL, 'User', 'user.index', $ADMINISTRATION, 2),
        (2, 0, NULL, 'Manage Role', NULL, $ADMINISTRATION, 1),
        (3, 2, NULL, 'Add Role', 'userRole.index', $ADMINISTRATION, 1),
        (4, 2, NULL, 'Add Role Permission', 'rolePermission.index', $ADMINISTRATION, 1),
        (5, 0, NULL, 'Change Password', 'changePassword.index', $ADMINISTRATION, 1),
        
        (". MenuHelper::getIdOf('EMPLOYEES') .", 0, NULL, 'Department', 'department.index', $EMPLOYEES, 1),
        (". MenuHelper::getIdOf('EMPLOYEES',1) .", 0, NULL, 'Designation', 'designation.index', $EMPLOYEES, 1),
        (". MenuHelper::getIdOf('EMPLOYEES',2) .", 0, NULL, 'Branch', 'branch.index', $EMPLOYEES, 1),
        (". MenuHelper::getIdOf('EMPLOYEES',3) .", 0, NULL, 'Manage Employee', 'employee.index', $EMPLOYEES, 1),
        (". MenuHelper::getIdOf('EMPLOYEES',4) .", 0, NULL, 'Import Employee', 'employee.bulk', $EMPLOYEES, 1),
        (". MenuHelper::getIdOf('EMPLOYEES',5) .", 0, NULL, 'Warning', 'warning.index', $EMPLOYEES, 1),
        (". MenuHelper::getIdOf('EMPLOYEES',6) .", 0, NULL, 'Termination', 'termination.index', $EMPLOYEES, 1),
        (". MenuHelper::getIdOf('EMPLOYEES',7) .", 0, NULL, 'Promotion', 'promotion.index', $EMPLOYEES, 1),
        (". MenuHelper::getIdOf('EMPLOYEES',8) .", 0, NULL, 'Employee Permanent', 'permanent.index', $EMPLOYEES, 1),
        
        -- old id: 10
        (". MenuHelper::getIdOf('LEAVES') .", 0, NULL, 'Setup', NULL, $LEAVES, 1),
        (". MenuHelper::getIdOf('LEAVES',1) .", ". MenuHelper::getIdOf('LEAVES') .", NULL, 'Holiday Name', 'holiday.index', $LEAVES, 1),
        (". MenuHelper::getIdOf('LEAVES',2) .", ". MenuHelper::getIdOf('LEAVES') .", NULL, 'Holiday Date', 'publicHoliday.index', $LEAVES, 1),
        (". MenuHelper::getIdOf('LEAVES',3) .", ". MenuHelper::getIdOf('LEAVES') .", NULL, 'Weekly Days Off', 'weeklyHoliday.index', $LEAVES, 1),
        (". MenuHelper::getIdOf('LEAVES',4) .", ". MenuHelper::getIdOf('LEAVES') .", NULL, 'Leave Type', 'leaveType.index', $LEAVES, 1),
        (". MenuHelper::getIdOf('LEAVES',5) .", ". MenuHelper::getIdOf('LEAVES') .", NULL, 'Earn Leave Config', 'earnLeaveConfigure.index', $LEAVES, 1),
        
        (". MenuHelper::getIdOf('LEAVES',6) .", 0, NULL, 'Leave Application', NULL, $LEAVES, 1),
        (". MenuHelper::getIdOf('LEAVES',7) .", ". MenuHelper::getIdOf('LEAVES',6) .", NULL, 'Apply for Leave', 'applyForLeave.index', $LEAVES, 1),
        (". MenuHelper::getIdOf('LEAVES',8) .", ". MenuHelper::getIdOf('LEAVES',6) .", NULL, 'Requests', 'requestedApplication.index', $LEAVES, 1),
        (". MenuHelper::getIdOf('LEAVES',9) .", 0, NULL, 'Report', NULL, $LEAVES, 1),
        (". MenuHelper::getIdOf('LEAVES',10) .", ". MenuHelper::getIdOf('LEAVES',9) .", NULL, 'Leave Report', 'leaveReport.leaveReport', $LEAVES, 1),
        (". MenuHelper::getIdOf('LEAVES',11) .", ". MenuHelper::getIdOf('LEAVES',9) .", NULL, 'Summary Report', 'summaryReport.summaryReport', $LEAVES, 1),
        (". MenuHelper::getIdOf('LEAVES',12) .", ". MenuHelper::getIdOf('LEAVES',9) .", NULL, 'My Leave Report', 'myLeaveReport.myLeaveReport', $LEAVES, 1), 
        
        -- old id: 18
        (". MenuHelper::getIdOf('ATTENDANCE') .", 0, NULL, 'Setup', NULL, $ATTENDANCE, 1),
        (". MenuHelper::getIdOf('ATTENDANCE',1) .", ". MenuHelper::getIdOf('ATTENDANCE') .", NULL, 'Manage Work Shift', 'workShift.index', $ATTENDANCE, 1),
        (". MenuHelper::getIdOf('ATTENDANCE',2) .", 0, NULL, 'Report', NULL, $ATTENDANCE, 1),
        (". MenuHelper::getIdOf('ATTENDANCE',3) .", ". MenuHelper::getIdOf('ATTENDANCE',2) .", NULL, 'Daily Attendance', 'dailyAttendance.dailyAttendance', $ATTENDANCE, 1),
        (". MenuHelper::getIdOf('ATTENDANCE',4) .", ". MenuHelper::getIdOf('ATTENDANCE',2) .", NULL, 'Monthly Attendance', 'monthlyAttendance.monthlyAttendance', $ATTENDANCE, 1),
        (". MenuHelper::getIdOf('ATTENDANCE',5) .", ". MenuHelper::getIdOf('ATTENDANCE',2) .", NULL, 'My Attendance', 'myAttendanceReport.myAttendanceReport', $ATTENDANCE, 1),
        (". MenuHelper::getIdOf('ATTENDANCE',6) .", 0, NULL, 'Manual Attendance', 'manualAttendance.manualAttendance', $ATTENDANCE, 1),
        (". MenuHelper::getIdOf('ATTENDANCE',7) .", 0, NULL, 'Import Attendance', 'attendance.bulk', $ATTENDANCE, 1),
        (". MenuHelper::getIdOf('ATTENDANCE',8) .", ". MenuHelper::getIdOf('ATTENDANCE',2) .", NULL, 'Summary Report', 'attendanceSummaryReport.attendanceSummaryReport', $ATTENDANCE, 1),
        (". MenuHelper::getIdOf('ATTENDANCE',9) .", ". MenuHelper::getIdOf('ATTENDANCE') .", NULL, 'Access Restriction', 'attendance.dashboard', $ATTENDANCE, 1),
        
        (". MenuHelper::getIdOf('PAYROLL') .", 0, NULL, 'Setup', NULL, $PAYROLL, 1),
        -- (". MenuHelper::getIdOf('PAYROLL',1) .", 0, NULL, 'Allowance', 'allowance.index', $PAYROLL, 1),
        -- (". MenuHelper::getIdOf('PAYROLL',2) .", 0, NULL, 'Deduction', 'deduction.index', $PAYROLL, 1),
        (". MenuHelper::getIdOf('PAYROLL',3) .", 0, NULL, 'Pay Grade', 'payGrade.index', $PAYROLL, 1),
        (". MenuHelper::getIdOf('PAYROLL',4) .", 0, NULL, 'Cut-off', 'cutOff.index', $PAYROLL, 1),
        -- (". MenuHelper::getIdOf('PAYROLL',4) .", 0, NULL, 'Hourly Pay Grade', 'hourlyWages.index', $PAYROLL, 1),
        (". MenuHelper::getIdOf('PAYROLL',5) .", 0, NULL, 'Salary Sheet', 'generateSalarySheet.index', $PAYROLL, 1),
        (". MenuHelper::getIdOf('PAYROLL',6) .", ". MenuHelper::getIdOf('PAYROLL') .", NULL, 'Late Configuration', 'salaryDeductionRule.index', $PAYROLL, 1),
        (". MenuHelper::getIdOf('PAYROLL',7) .", 0, NULL, 'Report', NULL, $PAYROLL, 1),
        (". MenuHelper::getIdOf('PAYROLL',8) .", ". MenuHelper::getIdOf('PAYROLL',7) .", NULL, 'Payment History', 'paymentHistory.paymentHistory', $PAYROLL, 1),
        (". MenuHelper::getIdOf('PAYROLL',9) .", ". MenuHelper::getIdOf('PAYROLL',7) .", NULL, 'My Payroll', 'myPayroll.myPayroll', $PAYROLL, 1),
        (". MenuHelper::getIdOf('PAYROLL',10) .", 0, NULL, 'Manage Work Hour', NULL, $PAYROLL, 1),
        (". MenuHelper::getIdOf('PAYROLL',11) .", 0, NULL, 'Approve Work Hour', 'workHourApproval.create', $PAYROLL, 1),
        (". MenuHelper::getIdOf('PAYROLL',12) .", 0, NULL, 'Manage Bonus', NULL, $PAYROLL, 1),
        (". MenuHelper::getIdOf('PAYROLL',13) .", 0, NULL, 'Bonus Setting', 'bonusSetting.index', $PAYROLL, 1),
        (". MenuHelper::getIdOf('PAYROLL',14) .", 0, NULL, 'Generate Bonus', 'generateBonus.index', $PAYROLL, 1),
        (". MenuHelper::getIdOf('PAYROLL',15) .", 0, NULL, 'Tax Rules', 'taxSetup.index', $PAYROLL, 1),
        
        (36, 0, NULL, 'Performance Category', 'performanceCategory.index', $PERFORMANCE, 1),
        (37, 0, NULL, 'Performance Criteria', 'performanceCriteria.index', $PERFORMANCE, 1),
        (38, 0, NULL, 'Employee Performance', 'employeePerformance.index', $PERFORMANCE, 1),
        (39, 0, NULL, 'Report', NULL, $PERFORMANCE, 1),
        (40, 39, NULL, 'Summary Report', 'performanceSummaryReport.performanceSummaryReport', $PERFORMANCE, 1),
        (41, 0, NULL, 'Job Post', 'jobPost.index', $RECRUITMENT, 1),
        (42, 0, NULL, 'Job Candidate', 'jobCandidate.index', $RECRUITMENT, 1),
        
        
        (45, 0, NULL, 'Training Type', 'trainingType.index', $TRAINING, 1),
        (46, 0, NULL, 'Training List', 'trainingInfo.index', $TRAINING, 1),
        (47, 0, NULL, 'Training Report', 'employeeTrainingReport.employeeTrainingReport', $TRAINING, 1),
        (48, 0, NULL, 'Award', 'award.index', $AWARD, 1),
        (49, 0, NULL, 'Notice', 'notice.index', $NOTICE, 1),
        (50, 0, NULL, 'Settings', 'generalSettings.index', $SETTINGS, 1),
        
        (". MenuHelper::getIdOf('SETTINGS') .", 0, NULL, 'Front Setting', NULL, $SETTINGS, 1),
        (". MenuHelper::getIdOf('SETTINGS',1) .", ". MenuHelper::getIdOf('SETTINGS') .", NULL, 'General Setting', 'front.setting', $SETTINGS, 1),
        (". MenuHelper::getIdOf('SETTINGS',2) .", ". MenuHelper::getIdOf('SETTINGS') .", NULL, 'Front Service', 'service.index', $SETTINGS, 1),
        
        (". MenuHelper::getIdOf('SETTINGS',4) .", 0, NULL, 'Src Code, BNR, etc...', 'custom.index', $EMPLOYEES, 1)
        ");

    }
}
