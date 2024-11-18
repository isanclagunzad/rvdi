import HTTPMethod from "http-method-enum";
import axios from "axios";
import { accessWindowVar } from "src/services/parseVar";

export const AppFetch = async (
  pathname: string,
  method: HTTPMethod = HTTPMethod.GET,
  headers = {},
  body?: string | { [key: string]: any },
) => {
  const bodyForm = new FormData();
  typeof body === "object" &&
    body &&
    Object.keys(body).forEach((key) => {
      bodyForm.append(key, body[key as string]);
    });

  return await fetch(pathname, {
    method,
    headers: {
      ...(headers || {}),
      ...{},
    },
    body: body && bodyForm,
  }).then((response) => response.text());
};

export const AppAxios = async <DataType>(
  pathname: string,
  method: HTTPMethod = HTTPMethod.GET,
  data?: { [key: string]: any },
  headers = {},
) => {
  const loggedSessionData = accessWindowVar<{
    bearer_token: string;
    user_id: number;
  }>("loggedSessionData");
  const response = await axios({
    url: pathname.replace(`{user_id}`, String(loggedSessionData.user_id)),
    method,
    headers: {
      ...headers,
      accept: "application/json",
      authorization: `Bearer ${loggedSessionData.bearer_token}`,
    },
    data,
  });

  return response.data as DataType;
};
