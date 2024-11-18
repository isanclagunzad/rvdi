import { HTMLInputAutoCompleteAttribute } from "react";
import { AutoCompleteProps } from "antd/es/auto-complete";
import { BaseOptionType, DefaultOptionType } from "antd/es/select";

export interface AutoCompleteOption {
  label: string;
  value: any;
}

export interface AutoCompleteFieldProps
  extends Pick<AutoCompleteProps, "onChange" | "value"> {
  options: AutoCompleteOption[];
  placeholder: string;
  label: string;
  onSearch?: (searchKey: string | number, fieldName: string) => unknown;
  name?: string;
  onSelect?: () => unknown;
}
