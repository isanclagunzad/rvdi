import { Form, Input, Modal, InputNumber, Upload, Image } from "antd";
import React, { BaseSyntheticEvent, useEffect, useMemo, useState } from "react";
import { CustomFieldFormProps } from "src/pages/employee/customField/type";
import type { GetProp, UploadFile, UploadProps } from "antd";
import {
  addCustomField,
  BNR_FILES,
  SRC_CODE,
  updateCustomField,
} from "src/redux/slice/employeeSlice";
import { useDispatch } from "react-redux";
import { AppDispatch } from "src/redux/store";
import { PlusOutlined } from "@ant-design/icons";
import { CustomField } from "src/redux/slice/customFieldsSlice";
import AppImages from "src/components/image/images";

function CustomFieldForm(props: CustomFieldFormProps) {
  const [form] = Form.useForm();
  const dispatch: AppDispatch = useDispatch();

  const [editData, setEditData] = props.editDataState;

  const srcCodeObject = useMemo(
    () =>
      (editData?.customfield_value || [])
        .filter((field) => field.fieldtype.name === SRC_CODE)
        .reverse()[0],
    [editData],
  );
  const srcFieldValue = useMemo<number>(
    () => Number((srcCodeObject && srcCodeObject.value) || 0),
    [srcCodeObject, editData],
  );
  const srcFieldId = useMemo<number>(
    () => Number((srcCodeObject && srcCodeObject.id) || 0),
    [srcCodeObject, editData],
  );
  const [formValue, setFormValue] = useState<{
    srcCode: number;
    bnrFiles: string;
  }>({
    srcCode: 0,
    bnrFiles: "",
  });

  const modalOpen = useMemo(() => {
    return editData !== undefined;
  }, [editData]);

  const handleSubmit = async () => {
    let customFields: CustomField[] = [
      { name: SRC_CODE, value: String(formValue.srcCode), id: srcFieldId },
    ];

    if (fileList && fileList.length) {
      customFields = [
        ...customFields,
        ...fileList.map((value) => {
          return {
            name: BNR_FILES,
            value: value.originFileObj || value,
          };
        }),
      ];
    }

    for await (let { id, name, value } of customFields) {
      if (editData?.employee_id && value) {
        if (id) {
          await dispatch(
            updateCustomField({
              employeeId: editData?.employee_id,
              name,
              value,
              customFieldId: id,
            }),
          );
        } else {
          await dispatch(
            addCustomField({
              employeeId: editData?.employee_id,
              name,
              value,
            }),
          );
        }
        setEditData(undefined);
        props?.onClose && props?.onClose();
      }
    }
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
  }, [modalOpen, formValue]);

  const handleSrcCodeChange = (srcCode: number | null) => {
    if (typeof srcCode === "number") {
      setFormValue({
        ...formValue,
        srcCode,
      });
    }
  };

  const [previewOpen, setPreviewOpen] = useState(false);
  const [previewImage, setPreviewImage] = useState("");
  const [fileList, setFileList] = useState<UploadFile[]>([]);

  useEffect(() => {
    if (srcFieldValue) {
      setFormValue({
        ...formValue,
        srcCode: srcFieldValue,
      });
    }
  }, [srcFieldValue]);

  const handlePreview = async (file: UploadFile) => {
    if (!file.url && !file.preview) {
      file.preview = await getBase64(file.originFileObj as FileType);
    }

    setPreviewImage(file.url || (file.preview as string));
    setPreviewOpen(true);
  };

  const handleImageAttachment: UploadProps["onChange"] = ({
    fileList: newFileList,
  }) => setFileList(newFileList);

  type FileType = Parameters<GetProp<UploadProps, "beforeUpload">>[0];

  const getBase64 = (file: FileType): Promise<string> =>
    new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = () => resolve(reader.result as string);
      reader.onerror = (error) => reject(error);
    });

  const uploadButton = (
    <button style={{ border: 0, background: "none" }} type="button">
      <PlusOutlined />
      <div style={{ marginTop: 8 }}>Upload</div>
    </button>
  );

  return (
    <Modal
      title="Add Custom Field"
      open={modalOpen}
      onOk={handleSubmit}
      onCancel={() => setEditData(undefined)}
      okButtonProps={{
        disabled: error,
      }}
    >
      <Form
        form={form}
        name="basic"
        labelCol={{ span: 6 }}
        wrapperCol={{ span: 16 }}
        style={{ maxWidth: 700 }}
        initialValues={{ remember: true }}
        autoComplete="off"
        onSubmitCapture={handleSubmit}
      >
        <Form.Item label="Employee ID" name="employee ID">
          <Input
            defaultValue={editData?.employee_id}
            readOnly={!!editData?.employee_id}
          />
        </Form.Item>
        <Form.Item label="Employee Name" name="employee ID">
          <Input
            defaultValue={editData?.full_name}
            readOnly={!!editData?.full_name}
          />
        </Form.Item>
        <Form.Item label={SRC_CODE} name={SRC_CODE}>
          <InputNumber
            defaultValue={srcFieldValue}
            value={formValue.srcCode}
            onChange={handleSrcCodeChange}
          />
        </Form.Item>
        <Form.Item label={BNR_FILES} name={BNR_FILES}>
          <AppImages
            files={(editData?.customfield_value || [])?.filter((field) =>
              field.fieldtype.name.match(BNR_FILES),
            )}
          />
          <Upload
            action={undefined}
            listType="picture-card"
            fileList={fileList}
            onPreview={handlePreview}
            onChange={handleImageAttachment}
            beforeUpload={() => false}
          >
            {fileList.length >= 8 ? null : uploadButton}
          </Upload>

          {previewImage && (
            <Image
              wrapperStyle={{ display: "none" }}
              preview={{
                visible: previewOpen,
                onVisibleChange: (visible) => setPreviewOpen(visible),
                afterOpenChange: (visible) => !visible && setPreviewImage(""),
              }}
              src={previewImage}
            />
          )}
        </Form.Item>
      </Form>
    </Modal>
  );
}

export default React.memo(CustomFieldForm);
