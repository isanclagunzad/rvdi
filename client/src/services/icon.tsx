import { ManOutlined, WomanOutlined } from "@ant-design/icons";
import { ReactNode } from "react";
import styled from "styled-components";

const IconsPerKey: { [key: string]: () => ReactNode } = {
  gender: () => (
    <>
      <svg
        xmlns="http://www.w3.org/2000/svg"
        height="24px"
        viewBox="0 0 24 24"
        width="24px"
        fill="#5f6368"
      >
        <path d="M0 0h24v24H0V0z" fill="none" />
        <path d="M5.5 22v-7.5H4V9c0-1.1.9-2 2-2h3c1.1 0 2 .9 2 2v5.5H9.5V22h-4zM18 22v-6h3l-2.54-7.63C18.18 7.55 17.42 7 16.56 7h-.12c-.86 0-1.63.55-1.9 1.37L12 16h3v6h3zM7.5 6c1.11 0 2-.89 2-2s-.89-2-2-2-2 .89-2 2 .89 2 2 2zm9 0c1.11 0 2-.89 2-2s-.89-2-2-2-2 .89-2 2 .89 2 2 2z" />
      </svg>
    </>
  ),
  role: () => (
    <svg
      xmlns="http://www.w3.org/2000/svg"
      enable-background="new 0 0 24 24"
      height="24px"
      viewBox="0 0 24 24"
      width="24px"
      fill="#5f6368"
    >
      <rect fill="none" height="24" width="24" />
      <g>
        <path d="M7.5,21H2V9h5.5V21z M14.75,3h-5.5v18h5.5V3z M22,11h-5.5v10H22V11z" />
      </g>
    </svg>
  ),
  department: () => (
    <svg
      xmlns="http://www.w3.org/2000/svg"
      height="24px"
      viewBox="0 0 24 24"
      width="24px"
      fill="#5f6368"
    >
      <path d="M14 6v15H3v-2h2V3h9v1h5v15h2v2h-4V6h-3zm-4 5v2h2v-2h-2z" />
    </svg>
  ),
  branch: () => (
    <>
      <svg
        xmlns="http://www.w3.org/2000/svg"
        enable-background="new 0 0 24 24"
        height="24px"
        viewBox="0 0 24 24"
        width="24px"
        fill="#5f6368"
      >
        <g>
          <rect fill="none" height="24" width="24" />
        </g>
        <g>
          <g>
            <polygon points="16,12 9,2 2,12 3.86,12 0,18 7,18 7,22 11,22 11,18 18,18 14.14,12" />
            <polygon points="20.14,12 22,12 15,2 12.61,5.41 17.92,13 16,13 15.97,13 19.19,18 24,18" />
            <rect height="3" width="4" x="13" y="19" />
          </g>
        </g>
      </svg>
    </>
  ),
  designation: () => (
    <svg
      xmlns="http://www.w3.org/2000/svg"
      enable-background="new 0 0 24 24"
      height="24px"
      viewBox="0 0 24 24"
      width="24px"
      fill="#5f6368"
    >
      <g>
        <path d="M0,0h24v24H0V0z" fill="none" />
      </g>
      <g>
        <g>
          <circle cx="10" cy="8" r="4" />
          <path d="M10.67,13.02C10.45,13.01,10.23,13,10,13c-2.42,0-4.68,0.67-6.61,1.82C2.51,15.34,2,16.32,2,17.35V20h9.26 C10.47,18.87,10,17.49,10,16C10,14.93,10.25,13.93,10.67,13.02z" />
          <path d="M20.75,16c0-0.22-0.03-0.42-0.06-0.63l1.14-1.01l-1-1.73l-1.45,0.49c-0.32-0.27-0.68-0.48-1.08-0.63L18,11h-2l-0.3,1.49 c-0.4,0.15-0.76,0.36-1.08,0.63l-1.45-0.49l-1,1.73l1.14,1.01c-0.03,0.21-0.06,0.41-0.06,0.63s0.03,0.42,0.06,0.63l-1.14,1.01 l1,1.73l1.45-0.49c0.32,0.27,0.68,0.48,1.08,0.63L16,21h2l0.3-1.49c0.4-0.15,0.76-0.36,1.08-0.63l1.45,0.49l1-1.73l-1.14-1.01 C20.72,16.42,20.75,16.22,20.75,16z M17,18c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S18.1,18,17,18z" />
        </g>
      </g>
    </svg>
  ),
  employmentStatus: () => (
    <svg
      xmlns="http://www.w3.org/2000/svg"
      enable-background="new 0 0 24 24"
      height="24px"
      viewBox="0 0 24 24"
      width="24px"
      fill="#5f6368"
    >
      <g>
        <rect fill="none" height="24" width="24" />
      </g>
      <g>
        <path d="M20,7h-5V4c0-1.1-0.9-2-2-2h-2C9.9,2,9,2.9,9,4v3H4C2.9,7,2,7.9,2,9v11c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2V9 C22,7.9,21.1,7,20,7z M9,12c0.83,0,1.5,0.67,1.5,1.5S9.83,15,9,15s-1.5-0.67-1.5-1.5S8.17,12,9,12z M12,18H6v-0.75c0-1,2-1.5,3-1.5 s3,0.5,3,1.5V18z M13,9h-2V4h2V9z M18,16.5h-4V15h4V16.5z M18,13.5h-4V12h4V13.5z" />
      </g>
    </svg>
  ),
  attendance: () => (
    <svg
      xmlns="http://www.w3.org/2000/svg"
      enable-background="new 0 0 24 24"
      height="24px"
      viewBox="0 0 24 24"
      width="24px"
      fill="#5f6368"
    >
      <g>
        <path d="M0,0h24v24H0V0z" fill="none" />
      </g>
      <g>
        <path d="M14,2H6C4.9,2,4.01,2.9,4.01,4L4,20c0,1.1,0.89,2,1.99,2H18c1.1,0,2-0.9,2-2V8L14,2z M10.94,18L7.4,14.46l1.41-1.41 l2.12,2.12l4.24-4.24l1.41,1.41L10.94,18z M13,9V3.5L18.5,9H13z" />
      </g>
    </svg>
  ),
};

const IconStyled = styled.div``;

export const getIcon = (key: string) => {
  if (typeof IconsPerKey[key] === "function") {
    return <IconStyled>{IconsPerKey[key]()}</IconStyled>;
  }
  return "";
};
