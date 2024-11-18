import pluralize from "pluralize";
import * as changeCase from "change-case";

export interface FilterResponseRow {
  [key: `${string}_id`]: number;

  [key: string]: any;
}

export type FilterCategoryValueType = string | number | FilterResponseRow;

export type FilterCategoryValue = { [key: string]: FilterCategoryValueType };

export interface FiltersResponse {
  [key: string]: FilterCategoryValue[];
}

export interface FilterOption {
  value: any;
  label: string;
}

export interface FilterOptions {
  [key: number]: {
    text: string;
    key: string;
    options: FilterOption[];
  };
}

export const CustomRowLabel: { [key: string]: string } = {
  employees: "${first_name} ${last_name}",
};

export const parseLabel = (
  tableName: string,
  item: { [key: string]: string | number | FilterResponseRow },
) => {
  if (item && `${tableName}_id` in item) {
    return {
      value: item[`${tableName}_id`] || 0,
      label: item[`${tableName}_name`] as string,
    };
  }
};

const getObjectPatternAsString = (
  obj: FilterCategoryValue,
  pattern: string,
) => {
  return pattern
    .split("$")
    .map((item) => {
      const fieldKey: string = String(item.match(/\{[A-z_]{1,}\}/)).replace(
        /[\{\}]{1}/g,
        "",
      );
      return item.replace(`{${fieldKey}}`, String(obj[fieldKey] || ""));
    })
    .join("");
};

export const FILTER_ORDERS = ["Employees", "Gender"];

export const getFiltersAsOptions = async (
  orderBy: string[] = FILTER_ORDERS,
): Promise<FilterOptions> => {
  const response = await getFilters();
  let result = Object.keys(response).map((filterKey) => {
    return {
      key: filterKey,
      text: changeCase.sentenceCase(filterKey),
      options: response[filterKey].map((item) => {
        const singularKey = pluralize.singular(filterKey);
        const keyPatterns = CustomRowLabel[filterKey];

        if (keyPatterns) {
          return {
            value: item[`${singularKey}_id`],
            label: getObjectPatternAsString(item, keyPatterns),
          };
        } else if (typeof item === "string") {
          return { value: item, label: item };
        } else if (typeof item[`${singularKey}_id`] === "number") {
          return {
            value: item[`${singularKey}_id`] || 0,
            label: item[`${singularKey}_name`] as string,
          };
        }
        return {
          value: 0,
          label: "",
        };
      }),
    };
  });

  orderBy.reverse().forEach((columnKey) => {
    const findIndexValue = result.filter((item) => item.text === columnKey);
    if (findIndexValue.length) {
      const index = result.indexOf(findIndexValue[0]);
      result.splice(index, 1);
      result.unshift(findIndexValue[0]);
    }
  });

  return result;
};

export const getFilters = async (): Promise<FiltersResponse> => {
  return await fetch("/filters").then((response) => response.json());
};
