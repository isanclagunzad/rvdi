import { Col, List, Progress, Row } from "antd";
import { FileUploadState } from "src/pages/attendance/type";
import { useDispatch, useSelector } from "react-redux";
import {
  getBulkUploadState,
  setUploadCount,
} from "src/redux/slice/bulkUploadStateSlice";
import { useEffect, useMemo, useState } from "react";
import axios, { AxiosResponse } from "axios";
import { accessWindowVar } from "src/services/parseVar";
import { UploadProgressBar } from "src/pages/attendance/style";
import type { ProgressProps } from "antd";

export interface BulkAttendanceUpload extends FileUploadState {
  index: number;
}

function BulkAttendanceUpload(uploadQueue: BulkAttendanceUpload) {
  const [message, setMsg] = useState("");
  const loggedSessionData = accessWindowVar<{ bearer_token: string }>(
    "loggedSessionData",
  );
  const bulkUploadState = useSelector(getBulkUploadState);
  const dispatch = useDispatch();
  const [progress, setProgress] = useState(0);
  const twoColors = useMemo<ProgressProps["strokeColor"]>(() => {
    return {
      "0%": "#108ee9",
      "60%": message.match("Skip") ? "#108ee9" : "#87d068",
    };
  }, [message]);

  useEffect(() => {
    (async () => {
      if (bulkUploadState.count === uploadQueue.index) {
        setProgress(0);
        const formData = new FormData();
        formData.append("file", uploadQueue.file, "Biometric.dat");

        try {
          axios
            .post("/api/attendance/bulk-upload", formData, {
              withCredentials: true,
              headers: {
                accept: "application/json",
                "content-type": "multipart/form-data",
                authorization: `Bearer ${loggedSessionData.bearer_token}`,
              },
              onUploadProgress: (progressEvent) => {
                const percentCompleted = Math.round(
                  (progressEvent.loaded * 100) / (progressEvent?.total || 100),
                );
                setProgress(percentCompleted === 100 ? 50 : percentCompleted);
              },
            })
            .then((response) => {
              setProgress(100);
              if (response?.data?.success) {
                setMsg(response?.data?.success);
              }

              setTimeout(() => {
                dispatch(setUploadCount(uploadQueue.index + 1));
              }, 100);
            })
            .catch(() => {
              setProgress(-1);
            });
        } catch (error) {
          console.error("Error uploading file", error);
        }

        //dispatch(setUploadCount(bulkUploadState.count + 1));
      }
    })();
  }, [bulkUploadState.count]);

  return (
    <List.Item>
      <Row style={{ width: "100%" }}>
        <Col span={6}>{uploadQueue.name}</Col>
        <Col span={18}>
          <UploadProgressBar>
            <label>{message}</label>
            {!!progress && (
              <Progress
                percent={progress}
                strokeColor={twoColors}
                status={
                  progress > 0 && progress < 100
                    ? "active"
                    : progress === -1
                      ? "exception"
                      : undefined
                }
              />
            )}
          </UploadProgressBar>
        </Col>
      </Row>
    </List.Item>
  );
}

export default BulkAttendanceUpload;
