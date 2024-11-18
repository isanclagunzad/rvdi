import AdvanceSearch from "src/components/advance-search";
import BladeLayout from "src/components/blade/layout";
import { useEffect, useState } from "react";
import { AppAxios } from "src/services/fetch";
import { Button, Pagination, Table } from "antd";
import { EmployeeResponse, EmployeeTableRow } from "src/pages/employee/type";
import CustomFieldForm from "src/pages/employee/customField/customFieldForm";
import { Employee } from "src/types/employee";
import { BNR_FILES, SRC_CODE } from "src/redux/slice/employeeSlice";
import { useDispatch } from "react-redux";
import { getCustomFields } from "src/redux/slice/customFieldsSlice";
import { AppDispatch, RootState } from "src/redux/store";
import { getLoggedData } from "src/services/parseVar";
import AppImages from "src/components/image/images";

const EmployeeCustom = () => {
  const [editData, setEditData] = useState<EmployeeTableRow>();
  const [dataSource, setDataSource] = useState<EmployeeTableRow[]>([]);
  const [page, setPage] = useState(1);
  const [pageSize, setPageSize] = useState(10);
  const [totalResult, setTotalResult] = useState(1000);
  const [urlParams, setUrlParams] = useState("");
  const dispatch: AppDispatch = useDispatch();
  const { employee_id } = getLoggedData();
  const [reload, setReload] = useState<boolean>();

  useEffect(() => {
    employee_id &&
      (async () => {
        const response = await dispatch(
          getCustomFields({ employeeId: employee_id }),
        );
      })();
  }, [employee_id]);

  useEffect(() => {
    if (reload === true) {
      getAll();
      setReload(false);
    }
  }, [reload]);

  const getAll = async () => {
    const response = await AppAxios<EmployeeResponse>(
      `/api/employees?page=${page}&page_size=${pageSize}&${urlParams}`,
    );
    if (response?.data?.results?.data) {
      setDataSource(
        response.data.results.data.map((employee) => {
          return {
            key: employee.employee_id,
            full_name: `${employee.first_name || ""} ${employee.last_name || ""}`,
            ...employee,
            [SRC_CODE]: (employee.customfield_value || [])
              .filter((field) => {
                return field.fieldtype.name === SRC_CODE;
              })
              .reverse()[0]?.value,
            bnr_files: (employee.customfield_value || [])
              .filter((field) => {
                return field.fieldtype.name === BNR_FILES;
              })
              .map((field) => field.value),
          };
        }),
      );
      setTotalResult(response.data.results.total);
    }
  };

  const handleEdit = (row: EmployeeTableRow) => {
    return () => {
      setEditData(row);
    };
  };

  const columns = [
    {
      title: "Employee",
      dataIndex: "full_name",
    },
    {
      title: SRC_CODE,
      dataIndex: SRC_CODE,
    },
    {
      title: BNR_FILES,
      dataIndex: BNR_FILES,
      render: (key: string, row: EmployeeTableRow, ...arg: any) => {
        return (
          <AppImages
            files={(row.customfield_value || []).filter(
              (field) => !!field.fieldtype.name.match(BNR_FILES),
            )}
          />
        );
      },
    },
    {
      title: "Actions",
      dataIndex: "actions",
      render: (key: string, row: EmployeeTableRow) => {
        return (
          <Button key={key} type="primary" ghost onClick={handleEdit(row)}>
            Edit
          </Button>
        );
      },
    },
  ].map((column) => {
    return {
      ...column,
      key: column.dataIndex,
    };
  });

  const handlePageChange = (page: number, pageSize: number) => {
    setPage(page);
    setPageSize(pageSize);
  };

  const handleSearch = (urlParams: string) => {
    setUrlParams(urlParams);
  };

  useEffect(() => {
    getAll();
  }, [page, urlParams, pageSize]);

  return (
    <BladeLayout title="Employee Custom Fields">
      {editData && (
        <CustomFieldForm
          editDataState={[editData, setEditData]}
          onClose={() => setReload(true)}
        />
      )}
      <AdvanceSearch onSearch={handleSearch} />
      <Table dataSource={dataSource} columns={columns} pagination={false} />
      <Pagination
        pageSize={pageSize}
        current={page}
        total={totalResult}
        onChange={handlePageChange}
      />
    </BladeLayout>
  );
};

export default EmployeeCustom;
