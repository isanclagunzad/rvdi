import React from "react";
import "./index.css";
import App from "./App";
import RenderRootById from "src/services/root";
import Sidebar from "src/pages/all/sidebar";

RenderRootById(<App />, "react-hr");
RenderRootById(<Sidebar />, "react-sidebar");
RenderRootById(<App />, "react-blade-layout", "react-hr");
