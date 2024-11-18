import { Image } from "antd";
import getAxiosInstance from "src/services/axios";
import { CustomFieldValue } from "src/types/employee";
import { memo } from "react";
import AppImage from "src/components/image/image";
import styled from "styled-components";

const ImagesStyled = styled.div`
  max-width: 300px;
  overflow: auto hidden;
  height: 60px;
  white-space: nowrap;
  > * {
    display: inline-block;
    width: 50px;
  }
`;

function AppImages({ files }: { files: CustomFieldValue[] } = { files: [] }) {
  return (
    <ImagesStyled>
      <Image.PreviewGroup>
        {files.map((file) => {
          return <AppImage file={file} />;
        })}
      </Image.PreviewGroup>
    </ImagesStyled>
  );
}

export default memo(AppImages);
