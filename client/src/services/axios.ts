// src/axiosConfig.ts

import axios, { AxiosInstance } from "axios";
import { getLoggedData } from "src/services/parseVar";

const axiosInstance = axios.create({
  baseURL: "/",
});

const getAxiosInstance = (): AxiosInstance => {
  const loggedData = getLoggedData();

  // Set the authorization header for all requests
  axiosInstance.defaults.headers.common["Authorization"] =
    `Bearer ${loggedData.bearer_token}`;

  return axiosInstance;
};

export default getAxiosInstance;
