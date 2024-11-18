import { memo, useEffect, useState } from "react";
import BladeLayout from "../../components/blade/layout";
import { Button, Table } from "antd";
import { CutOffFormData, CutOffRow } from "./type";
import { fetchCutoffs, selectCutoffs } from "src/redux/slice/cutOffSlice";
import { useAppDispatch } from "src/redux/store";
import { useSelector } from "react-redux";
import CutOffModal from "src/pages/cutoff/cutOffModal";
import { DeleteOutlined } from "@ant-design/icons";

const CutOffPage = memo(() => {
  const dispatch = useAppDispatch();
  const { cutoffs, loading, error } = useSelector(selectCutoffs);
  const [editData, setEditData] = useState<CutOffFormData>();

  useEffect(() => {
    dispatch(fetchCutoffs());
  }, [dispatch]);

  useEffect(() => {
    setDataSource(
      cutoffs.map((data, key) => ({
        key,
        ...data,
      })),
    );
  }, [cutoffs]);

  const handleAdd = () => {
    setEditData({});
  };

  const handleEdit = (row: CutOffRow) => {
    return () => {
      console.log({ row });
      setEditData(row);
    };
  };

  const [dataSource, setDataSource] = useState<CutOffRow[]>([]);

  const columns = [
    {
      title: "Name",
      dataIndex: "name",
    },
    {
      title: "Start ",
      dataIndex: "start_date",
      width: "150px",
    },
    {
      title: "End ",
      dataIndex: "end_date",
      width: "150px",
    },
    {
      title: "Actions",
      dataIndex: "actions",
      width: "150px",
      render: (key: string, row: CutOffRow) => {
        return (
          <>
            <Button
              key={`edit-${key}`}
              type="primary"
              ghost
              onClick={handleEdit(row)}
            >
              Edit
            </Button>
            &nbsp;
            <Button
              key={`del-${key}`}
              type="primary"
              danger
              onClick={handleEdit(row)}
            >
              <DeleteOutlined />
            </Button>
          </>
        );
      },
    },
  ];

  return (
    <BladeLayout
      title="Cut Off Management"
      buttons={[{ href: "#", text: "Add", onClick: handleAdd }]}
    >
      <CutOffModal editData={editData} onClose={() => setEditData(undefined)} />
      <Table dataSource={dataSource} columns={columns} pagination={false} />
    </BladeLayout>
  );
});

export default CutOffPage;
