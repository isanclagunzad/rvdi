import React from "react";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import Home from "./pages/home";
import Employee from "./pages/employee";
import Dashboard from "./pages/dashboard/dashboard";
import DailyAttendance from "./pages/dailyAttendance/dailyAttendance";
import BulkAttendance from "src/pages/attendance/bulkAttendance";
import EmployeeCustom from "src/pages/employee/customField/customField";
import ManageCustomFields from "src/pages/employee/manageCustomFields";
import PayGradeElement from "src/pages/employee/payGradeElement";
import CutOffPage from "./pages/cutoff/cutOffPage";

const AppRouter: React.FC = () => {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/employee" element={<Employee />} />
        <Route path="/dashboard" element={<Dashboard />} />
        <Route path="/dailyAttendance" element={<DailyAttendance />} />
        <Route path="/bulkAttendance" element={<BulkAttendance />} />
        <Route path="/employee/custom" element={<EmployeeCustom />} />
        <Route
          path="/employee/:employee_id/edit"
          element={<PayGradeElement />}
        />
        <Route
          path="/employee/custom/manage"
          element={<ManageCustomFields />}
        />
        <Route path="/cutOff" element={<CutOffPage />} />
      </Routes>
    </BrowserRouter>
  );
};

export default AppRouter;
