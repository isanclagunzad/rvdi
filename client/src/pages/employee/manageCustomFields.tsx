import BladeLayout from "src/components/blade/layout";
import { Button, Form, Input, Modal, Table } from "antd";
import { useEffect, useMemo, useState } from "react";
import { AppAxios, AppFetch } from "src/services/fetch";
import { accessWindowVar, useWindowsVar } from "src/services/parseVar";
import HTTPMethod from "http-method-enum";
import {
  EmployeeCustomField,
  EmployeeCustomFieldResponse,
} from "src/pages/employee/type";
import { SRC_CODE } from "src/redux/slice/employeeSlice";

type FieldType = {
  name?: string;
};

function ManageCustomFields() {
  const [form] = Form.useForm();
  const [dataSource, setDataSource] = useState([
    {
      name: SRC_CODE,
    },
  ]);

  const columns = [
    {
      title: "Field Name",
      dataIndex: "name",
      key: "name",
    },
  ];

  const [isModalOpen, setModalOpen] = useState(false);
  const [customField, setCustomField] = useState({
    name: "",
    value: "NO DATA",
  });
  const handleAdd = () => {
    setModalOpen(true);
  };

  const [error, setError] = useState(false);

  useEffect(() => {
    (async () => {
      try {
        await form.validateFields();
        setError(false);
      } catch (e) {
        setError(true);
      }
    })();
  }, [customField, isModalOpen]);

  const [submitted, setSubmitted] = useState<EmployeeCustomField>();
  const handleSubmit = async (e: React.MouseEvent<any>) => {
    const response = await AppAxios<EmployeeCustomField>(
      "/api/employee/{user_id}/custom-fields",
      HTTPMethod.POST,
      customField,
    );
    setSubmitted(response);
  };

  useEffect(() => {
    (async () => {
      const response =
        await AppAxios<EmployeeCustomFieldResponse>("/api/custom-fields");
      setDataSource(response.data);

      const employeeCustomFields = await AppAxios(
        "/api/employee/{user_id}/custom-fields",
      );
    })();
  }, [submitted]);

  return (
    <BladeLayout
      title="Manage Custom Fields"
      buttons={[{ href: "#", text: "Add", onClick: handleAdd }]}
    >
      <Modal
        title="Add Custom Field"
        open={isModalOpen}
        onOk={handleSubmit}
        onCancel={() => setModalOpen(false)}
        okButtonProps={{
          disabled: error,
        }}
      >
        <Form
          form={form}
          name="basic"
          labelCol={{ span: 6 }}
          wrapperCol={{ span: 16 }}
          style={{ maxWidth: 600 }}
          initialValues={{ remember: true }}
          autoComplete="off"
          onSubmitCapture={handleSubmit}
        >
          <Form.Item<FieldType>
            label="Field Name"
            name="name"
            rules={[{ required: true, message: "Field name is required." }]}
          >
            <Input
              value={customField.name}
              onChange={(e) =>
                setCustomField({
                  ...customField,
                  name: e.target.value,
                })
              }
            />
          </Form.Item>
        </Form>
      </Modal>
      <Table dataSource={dataSource} columns={columns} />
      <Button type="primary">Add Field</Button>
    </BladeLayout>
  );
}

export default ManageCustomFields;
