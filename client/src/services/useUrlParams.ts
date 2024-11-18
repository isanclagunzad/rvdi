import { useEffect, useState } from "react";
import queryString from "query-string";

export interface UrlParamsReturn {
  [key: string]: string;
}

export const useUrlParams = (): UrlParamsReturn => {
  const [response, setResponse] = useState<UrlParamsReturn>({});

  useEffect(() => {
    const json = queryString.parse(window.location.search) as UrlParamsReturn;
    setResponse(json);
  }, [window.location]);
  return response;
};
