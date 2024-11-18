import React, { BaseSyntheticEvent, useEffect, useState } from "react";
import { Button, Form, Image, Input, InputNumber, Modal, Upload } from "antd";
import { CutOffFormData, CutOffRow } from "src/pages/cutoff/type";
import HTTPMethod from "http-method-enum";
import { useAppDispatch } from "src/redux/store";
import { saveCutOff, updateCutOff } from "src/redux/slice/cutOffSlice";

interface CutOffModalProps {
  editData?: CutOffFormData;
  onClose?: (reload?: boolean) => unknown;
}

const CutOffModal = (props: CutOffModalProps) => {
  const dispatch = useAppDispatch();
  const [form] = Form.useForm();
  const [modalOpen, setModalOpen] = useState(false);
  const [editData, setEditData] = useState<CutOffFormData>();
  const [error, setError] = useState(false);

  const handleClose = (reload = false) => {
    props?.onClose && props?.onClose(reload);
  };

  const handleSubmit = async () => {
    console.log("submit", [props.editData, form.getFieldsValue()]);
    if (!props.editData) {
      return;
    }
    if (Object.values(props.editData).length === 0) {
      await dispatch(saveCutOff(form.getFieldsValue()));
    } else {
      await dispatch(
        updateCutOff({
          id: props.editData.id,
          ...form.getFieldsValue(),
        }),
      );
    }
    handleClose(true);
  };

  useEffect(() => {
    setEditData(props.editData);
    if (props.editData) {
      form.setFieldValue("name", props.editData.name);
      form.setFieldValue("start_date", props.editData.start_date);
      form.setFieldValue("end_date", props.editData.end_date);
    }
  }, [props.editData]);

  return (
    <Modal
      title={
        (props.editData && Object.values(props.editData).length
          ? "Edit"
          : "Add") + " Cut-off"
      }
      open={!!props.editData}
      onOk={handleSubmit}
      onCancel={() => handleClose(false)}
      okButtonProps={{
        disabled: error,
      }}
    >
      <Form
        form={form}
        name="cutoff"
        labelCol={{ span: 6 }}
        wrapperCol={{ span: 16 }}
        style={{ maxWidth: 700 }}
        initialValues={{ remember: true }}
        autoComplete="off"
        onSubmitCapture={handleSubmit}
      >
        <Form.Item label="Name" name="name">
          <Input value={(editData && editData?.name) || ""} required />
        </Form.Item>
        <Form.Item label="Start" name="start_date">
          <InputNumber
            value={(editData && editData?.start_date) || undefined}
            min={1}
            max={31}
            required
          />
        </Form.Item>
        <Form.Item label="End" name="end_date">
          <InputNumber
            value={(editData && editData?.end_date) || undefined}
            min={1}
            max={31}
            required
          />
        </Form.Item>
      </Form>
    </Modal>
  );
};

export default CutOffModal;
