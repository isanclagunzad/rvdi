import { decode } from "html-entities";
import dayjs from "dayjs";
import { useEffect, useState } from "react";

export const accessWindowVar = <DataType>(variableName: string): DataType => {
  let result = [] as DataType;

  try {
    result = eval(variableName);
    result = JSON.parse(decode(result as string));
  } catch (e) {}

  console.log("var", variableName, result);

  return result as DataType;
};

export const parseVar = (htmlString: string) => {
  return JSON.parse(decode(htmlString));
};

export const useWindowsVar = (varName: string = "") => {
  const [value, setValue] = useState();

  useEffect(() => {
    setTimeout(() => setValue(accessWindowVar(varName)), 100);
  }, []);

  return { value };
};

export interface LoggedData {
  bearer_token: string;
  employee_id: number;
}

export const getLoggedData = (): LoggedData => {
  return (accessWindowVar("loggedSessionData") as LoggedData) || {};
};
