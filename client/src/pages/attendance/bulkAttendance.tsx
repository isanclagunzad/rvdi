import { InboxOutlined } from "@ant-design/icons";
import type { UploadProps } from "antd";
import { Alert, List, Upload } from "antd";
import { useEffect, useMemo, useState } from "react";
import { accessWindowVar } from "src/services/parseVar";
import { BulkAttendanceStyle } from "src/pages/attendance/style";
import { FileUploadState } from "src/pages/attendance/type";
import BulkAttendanceUpload from "src/pages/attendance/bulkAttendanceUpload";
import { getHeaders } from "src/services/getHeaders";

const { Dragger } = Upload;

function BulkAttendance() {
  const headers = getHeaders();
  const maxRowCount = 2000;
  const [triggerUpload, setTriggerUpload] = useState(false);
  const [uploadQueueList, setUploadQueueList] = useState<FileUploadState[]>([]);
  const [fileContent, setFileContent] = useState("");

  useEffect(() => {
    (async () => {
      if (fileContent) {
        const contents = fileContent.split("\n");
        let batch = 1;
        for (let x = 0; x < contents.length; x += maxRowCount) {
          const fileContent = contents.slice(x, x + maxRowCount).join("\n");
          uploadQueueList.push({
            name: `Biometric batch ${batch++}`,
            file: new Blob([fileContent]),
            uploaded: false,
          });
        }
        setUploadQueueList([...uploadQueueList]);
      }
    })();
  }, [fileContent]);

  const props: UploadProps = useMemo(
    () => ({
      fileList: [],
      name: "file",
      multiple: true,
      action: "/api/attendance/bulk-upload",
      accept: ".dat",
      headers: headers,
      onChange: async (...props: any) => {
        if (!triggerUpload) {
          const info = props[0];
          const file = info.file as Blob;

          const reader = new FileReader();
          reader.onload = (e) => {
            const result = String(e?.target?.result);
            setFileContent(result);
          };
          reader.onerror = (e) => {
            console.error(`Error reading :`, e);
          };
          reader.readAsText(file);
        }
      },
      onDrop(e) {
        console.log("Dropped files", e, e.dataTransfer.files);
      },
      beforeUpload: () => triggerUpload,
    }),
    [uploadQueueList, headers],
  );

  return (
    <BulkAttendanceStyle>
      <Dragger {...props}>
        <p className="ant-upload-drag-icon">
          <InboxOutlined />
        </p>
        <p className="ant-upload-text">Click or drag Biometric file</p>
      </Dragger>
      &nbsp;
      {uploadQueueList.length > 1 && (
        <Alert
          message={`Biometric File is too large! Record is processed by batch of ${maxRowCount} clock in/out. Please don't close browser!`}
          banner
        />
      )}
      &nbsp;
      <List
        size="small"
        header={<div>List of batches</div>}
        bordered
        dataSource={uploadQueueList}
        renderItem={(uploadQueue, index) => (
          <BulkAttendanceUpload {...uploadQueue} index={index} />
        )}
      />
    </BulkAttendanceStyle>
  );
}

export default BulkAttendance;
