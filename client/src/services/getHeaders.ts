import { accessWindowVar } from "src/services/parseVar";

export interface HeaderWithAuth {
  [key: string]: string;
  Authorization: `Bearer ${string}`;
}

export const getHeaders = (): HeaderWithAuth => {
  const loggedSessionData = accessWindowVar<{ bearer_token: string }>(
    "loggedSessionData",
  );
  return {
    Authorization: `Bearer ${loggedSessionData.bearer_token}`,
  };
};
