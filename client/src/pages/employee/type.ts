import { Employee } from "src/types/employee";

export interface EmployeeTableRow extends Employee {
  full_name: string;
  src_code?: string;
  brn_files?: string;
}

export interface EmployeeResponse {
  data: {
    results: {
      data: Employee[];
      total: number;
    };
  };
}
export interface EmployeeCustomFieldResponse {
  data: EmployeeCustomField[];
}

export interface EmployeeCustomField {
  name: string;
}
