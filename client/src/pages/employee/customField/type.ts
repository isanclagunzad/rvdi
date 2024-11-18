import { Dispatch, SetStateAction } from "react";
import { EmployeeCustomField, EmployeeTableRow } from "src/pages/employee/type";

export enum CUSTOM_FIELD_MANAGE_ACTION {
  none,
  edit,
  add,
}

export interface CustomFieldData {
  [key: string]: string;
}

export type CustomFieldDataType = CustomFieldData | undefined;

export interface CustomFieldFormProps {
  data?: EmployeeCustomField;
  editDataState: [
    EmployeeTableRow | undefined,
    Dispatch<SetStateAction<EmployeeTableRow | undefined>>,
  ];
  onClose?: () => unknown;
}
