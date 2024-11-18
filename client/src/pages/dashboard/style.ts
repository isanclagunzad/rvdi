import styled from "styled-components";

export const DepartmentStyled = styled.div`
  font-size: 10px;
  > div {
    position: relative;
  }

  .white-box {
    position: relative;
    h3 {
      display: flex;
      align-items: center;
      justify-content: left;
    }
  }

  .ant-badge {
    margin-right: 10px;
    margin-bottom: 10px;
    width: 45%;
    max-width: 130px;
    margin-right: 5%;
    > div {
      font-size: 11px;
      border: solid #d5d5d5 1px;
      border-radius: 5px;
      text-align: left;
      padding: 5px;
      font-weight: 600;
      white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;
    }
  }
  .total {
    font-size: 15px;
    text-align: right;
  }
`;

export const SeeMoreStyle = styled.a`
  width: 100%;
  display: block;
  text-align: right;
  font-weight: 600;
`;
