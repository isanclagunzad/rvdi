export const START_DATE = "start_date";
export const END_DATE = "end_date";

export interface DailyAttendanceItem {
  employee_id: number;
  photo: null;
  fullName: string;
  department_name: string;
  employee_attendance_id: `${number}`;
  finger_print_id: `${number}`;
  date: string;
  working_time: string;
  in_time: string;
  out_time: string;
  late_count_time: string;
  is_late: string;
  total_late_time: string;
  over_time: string;
}

export interface DailyAttendanceDepartmentItemMap {
  [key: string]: DailyAttendanceItem;
}
