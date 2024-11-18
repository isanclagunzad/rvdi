import { useEffect, useMemo, useState } from "react";
import { accessWindowVar, useWindowsVar } from "@/services/parseVar";
import {
  DailyAttendanceDepartmentItemMap,
  DailyAttendanceItem,
} from "@/pages/dailyAttendance/type";
import { Button, Modal } from "antd";
import {
  CheckCircleFilled,
  CheckOutlined,
  DeleteFilled,
} from "@ant-design/icons";
import { DeleteInfoStyle } from "@/pages/dailyAttendance/style";
import { AppFetch } from "@/services/fetch";
import HTTPMethod from "http-method-enum";

function DailAttendanceTable() {
  const [loading, setLoading] = useState(true);
  const [deleting, setDeleting] = useState(false);
  const [deleted, setDeleted] = useState(false);
  const [deleteInfo, setDeleteInfo] = useState<DailyAttendanceItem>();
  const deleteItems = useMemo(() => {
    return Object.entries({
      Name: deleteInfo?.fullName,
      Date: deleteInfo?.date,
      "Time-in": deleteInfo?.in_time,
      "Time-out": deleteInfo?.out_time,
    });
  }, [deleteInfo]);

  const [modalOpen, setModalOpen] = useState(false);
  const [results, setResults] = useState<DailyAttendanceDepartmentItemMap>({});
  const csrfToken = useWindowsVar("csrfToken");

  useEffect(() => {
    const results =
      accessWindowVar<DailyAttendanceDepartmentItemMap>("results");
    setTimeout(() => setResults(results), 500);
    setLoading(false);
  }, []);

  const handleOk = async () => {
    if (!deleting) {
      setDeleting(true);
      const response = await AppFetch(
        `/attendance/${deleteInfo?.employee_attendance_id}/finger_print/${deleteInfo?.finger_print_id}/delete`,
        HTTPMethod.POST,
        {},
        {
          _method: "delete",
          _token: csrfToken.value,
        },
      );
      if (response.match("success")) {
        setDeleted(true);
        setTimeout(() => window.location.reload(), 1000);
      }
    }
  };
  const handleCancel = () => {
    setModalOpen(false);
  };

  const handleDelete = (attendance: DailyAttendanceItem) => {
    return () => {
      setDeleteInfo(attendance);
      setModalOpen(true);
    };
  };

  const resultKeys = useMemo(() => Object.keys(results), [results]);

  return (
    <>
      <Modal
        title={<>Delete Attendance</>}
        open={modalOpen}
        onOk={handleOk}
        onCancel={handleCancel}
        okType="primary"
        okText={
          deleted ? (
            <>
              Deleted <CheckOutlined />
            </>
          ) : deleting ? (
            "Deleting..."
          ) : (
            "Delete!"
          )
        }
        okButtonProps={{ danger: !deleting || !deleted }}
        centered={true}
      >
        <br />
        <b>Click "Delete" to confirm attendance delete!</b>
        <br />
        {deleteItems.map((item) => {
          return (
            <DeleteInfoStyle>
              <b>{item[0]} : </b>
              <span>{item[1]}</span>
            </DeleteInfoStyle>
          );
        })}
      </Modal>

      <table id="" className="table table-bordered">
        <thead className="tr_header">
          <tr>
            <th style={{ width: "100px" }}>S/L</th>
            <th>Date</th>
            <th>Employee Name</th>
            <th>Time in</th>
            <th>Time out</th>
            <th>Total Work Time</th>
            <th>Late</th>
            <th>Total Late Time</th>
            <th>Overtime</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          {resultKeys.length === 0 ? (
            <tr>
              <td colSpan={9}>
                {loading || resultKeys.length
                  ? "Loading data..."
                  : "No data available!"}
              </td>
            </tr>
          ) : (
            resultKeys.map((departmentKey) => {
              const departmentAttendance =
                Object.values(results[departmentKey]) || [];

              return (
                <>
                  <tr>
                    <td colSpan={9}>
                      <b>{departmentKey}</b>
                    </td>
                  </tr>
                  {departmentAttendance.map((attendance, index) => {
                    return (
                      <tr>
                        <td>{index}</td>
                        <td>{attendance.date}</td>
                        <td>{attendance.fullName}</td>
                        <td>{attendance.in_time}</td>
                        <td>{attendance.out_time}</td>
                        <td>{attendance.working_time}</td>
                        <td>
                          {attendance.is_late === "Yes" ? (
                            <b style={{ color: "red" }}>{attendance.is_late}</b>
                          ) : (
                            "No"
                          )}
                        </td>
                        <td>
                          {attendance.total_late_time == "00:00:00"
                            ? "--"
                            : attendance.total_late_time}
                        </td>
                        <td>{attendance.over_time}</td>
                        <td>
                          <Button danger onClick={handleDelete(attendance)}>
                            <DeleteFilled /> Delete
                          </Button>
                        </td>
                      </tr>
                    );
                  })}
                </>
              );
            })
          )}
        </tbody>
      </table>
    </>
  );
}

export default DailAttendanceTable;
