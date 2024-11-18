import { HTMLAttributes, ReactNode } from "react";
import styled from "styled-components";

interface BladeLayoutButton extends HTMLAttributes<HTMLAnchorElement> {
  text: string;
  icon?: ReactNode;
  href: string;
}

interface BladeLayoutProps {
  children: ReactNode;
  title: string;
  buttons?: BladeLayoutButton[];
}

const Style = styled.div`
  .ant-pagination {
    margin-top: 10px;
    float: right;
  }
`;

function BladeLayout(props: BladeLayoutProps) {
  return (
    <Style className="container-fluid">
      <div className="row bg-title">
        <div className="col-md-6">
          <ol className="breadcrumb">
            <li className="active breadcrumbColor">
              <a href="/dashboard">
                <i className="fa fa-home"></i> Dashboard
              </a>
            </li>
            <li>{props.title}</li>
          </ol>
        </div>
        <div className="col-md-6">
          {(props.buttons || []).map((buttonProps, index) => {
            const { text, icon } = buttonProps;
            return (
              <a
                key={`layout-btn-${index}`}
                className="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"
                {...buttonProps}
              >
                {icon}&nbsp;{text}
              </a>
            );
          })}
        </div>
      </div>
      <div className="row">
        <div className="col-sm-12">
          <div className="panel panel-info">
            <div className="panel-heading">
              <i className="mdi mdi-table fa-fw"></i> {props.title}
            </div>
          </div>
          <div className="panel-wrapper collapse in" aria-expanded="true">
            <div className="panel-body">{props.children}</div>
          </div>
        </div>
      </div>
    </Style>
  );
}

export default BladeLayout;
