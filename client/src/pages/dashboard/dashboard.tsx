import React, { useEffect, useState } from "react";

import { Employee } from "../../types/employee";
import Deparments from "./departments";
import { parseVar } from "@/services/parseVar";
import RenderRootById from "src/services/root";

function Dashboard() {
  const [upcomingBirthdays, setUpcomingBirthdays] = useState<Employee[]>([]);

  useEffect(() => {
    // @ts-ignore
    const upcomingBirthdays = parseVar(window.upcomingBirthdays);

    if (upcomingBirthdays) {
      setUpcomingBirthdays(upcomingBirthdays);
    }
  }, []);

  useEffect(() => {
    RenderRootById(<Deparments />, "react-hr-departments");
  }, []);

  return (
    <>
      <div className="row">
        <div className="col-md-12 col-lg-12 col-sm-12">
          <div className="panel">
            <div className="panel-heading">
              Birthday celebrants of the month 🎂🥳
            </div>
            <div className="table-responsive">
              <table className="table table-hover manage-u-table">
                <thead>
                  <tr>
                    <th className="text-center">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Date of birth</th>
                  </tr>
                </thead>
                <tbody>
                  {upcomingBirthdays ? (
                    upcomingBirthdays.map((employee, key) => {
                      return (
                        <tr key={key}>
                          <td className="text-center">
                            {employee.employee_id}
                          </td>
                          <td>
                            {employee.first_name} {employee.last_name}
                          </td>
                          <td>{employee.email}</td>
                          <td>{employee.date_of_birth}</td>
                        </tr>
                      );
                    })
                  ) : (
                    <tr>
                      <td colSpan={8}>No data available</td>
                    </tr>
                  )}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}

export default Dashboard;
