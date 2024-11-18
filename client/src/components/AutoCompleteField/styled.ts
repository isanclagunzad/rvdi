import styled from "styled-components";

export const AutoCompleteWrapper = styled.div`
  position: relative;
  margin-bottom: 16px;

  .ant-select {
    width: 90%;
    .ant-select-clear {
      margin-right: 12px;
    }

    .ant-input-affix-wrapper {
      padding-top: 28px; /* Adjust as needed */
    }

    .ant-select-selector {
      border-radius: 0;
      padding: 5px;
    }
  }
`;

export const FloatingLabel = styled.label<{ hasValue: boolean }>`
  position: absolute;
  top: ${(props) => (props.hasValue ? "-10px" : "6px")};
  left: 12px;
  pointer-events: none;
  transition: 0.2s ease all;
  font-size: ${(props) => (props.hasValue ? "12px" : "16px")};
  color: ${(props) => (props.hasValue ? "#1890ff" : "#888")};
  background: white;
`;
