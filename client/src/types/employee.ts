export interface CustomFieldValue {
  id: number;
  value: string;
  fieldtype: {
    id: number;
    name: string;
  };
}

export interface Employee {
  employee_id: number;
  date_of_birth: string;
  first_name: string;
  last_name: string;
  email: string;
  customfield_value?: CustomFieldValue[];
}
