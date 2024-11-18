import { Dispatch, SetStateAction } from "react";

export interface SearchCriteria {
  [key: string]: string | number;
}

export interface AdvanceSearchApiProps {
  searchCriteriaState: [
    SearchCriteria,
    Dispatch<SetStateAction<SearchCriteria>>,
  ];
}
