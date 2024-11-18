import { Image } from "antd";
import { useEffect, useRef, useState } from "react";
import { CustomFieldValue } from "src/types/employee";
import getAxiosInstance from "src/services/axios";
import styled from "styled-components";
import { DeleteFilled, DeleteOutlined } from "@ant-design/icons";

const ImageStyled = styled.div`
  position: relative;
  overflow: hidden;
  margin-right: 10px;
  z-index: 5;
`;

const ImageDeleteStyled = styled.div`
  --image-delete-size: 10px;
  position: absolute;
  top: -5px;
  right: 5px;
  height: var(--image-delete-size);
  width: var(--image-delete-size);
  border-radius: 5px;
  z-index: 10;
  padding: 0;
`;

function AppImage({ file }: { file: CustomFieldValue }) {
  const imageRef: any = useRef();
  const [src, setSrc] = useState<string>();
  useEffect(() => {
    (async () => {
      try {
        const customFieldTypeId = file.fieldtype.id;
        const customFieldId = file.id;
        const image = (await getAxiosInstance()
          .get(
            `/api/custom-fields/${customFieldTypeId}/value/${customFieldId}`,
            {
              responseType: "blob",
            },
          )
          .catch((e) => {
            console.error({ e }, { file });
          })) as { data: Blob };
        setSrc(URL.createObjectURL(image.data));
      } catch (e) {
        console.error({ e }, { file });
      }
    })();
  }, [imageRef]);
  return (
    <ImageStyled>
      <Image src={src} width={80} />
      <ImageDeleteStyled>
        <DeleteFilled />
      </ImageDeleteStyled>
    </ImageStyled>
  );
}

export default AppImage;
