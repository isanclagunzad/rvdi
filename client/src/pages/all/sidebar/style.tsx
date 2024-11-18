import * as Icons from "@ant-design/icons";
import styled from "styled-components";

const MenuItemIconsById: { [key: string]: string } = {
  Dashboard: "DashboardOutlined",
  Administration: "SettingOutlined",
  Employees: "UserOutlined",
  Leaves: "CoffeeOutlined",
  Attendance: "CheckSquareOutlined",
  Payroll: "DollarOutlined",
  Performance: "LineChartOutlined",
  Recruitment: "TeamOutlined",
  Training: "ReadOutlined",
  Award: "TrophyOutlined",
  "Notice Board": "NotificationOutlined",
  Settings: "SettingOutlined",
};

export const getMenuIcon = (key: string) => {
  //@ts-ignore
  const IconComponent = Icons[MenuItemIconsById[key]];
  if (IconComponent) {
    return <IconComponent />;
  }
  return <></>;
};

export const SidebarStyled = styled.div`
  span.side-navigation-panel-select-inner-option-text {
    font-size: 14px !important;
  }
`;
