import styled from "styled-components";
import {Row} from "antd";

const advanceSearchBorder = `solid #dddddd 1px`;

export const AdvanceSearchWrapperStyled = styled(Row)`
width: 100%;
`

export const AdvanceSearchStyled = styled.div`
  border: ${advanceSearchBorder};
  padding: 20px 15px 0;
  margin-bottom: 10px;
  position: relative; 

  > label {
    margin-bottom: 5px;
    position: absolute;
    top: -10px;
    background: white;
  }

  .ant-picker,
  .ant-select .ant-select-selector {
    border-radius: 0;
    width: 90%;
  }
  .ant-picker-input > input {
    font-weight: bold;
    color: #888;
    font-size: 16px;
  }
`;

export const ToolbarStyled = styled.div`
  border: ${advanceSearchBorder};
  width: 90%;
  float: right;
  height: calc(100% - 10px);
  text-align: center;
  padding-top: 20px;
  > * {
    margin: 5px;
  }
  span {
    color: white;
  } 
`;
