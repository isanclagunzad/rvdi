import ReactDOM from "react-dom/client";
import { ReactElement } from "react";

function RenderRootById(
  ReactNodeChildren: ReactElement,
  htmlId: string = "react-hr",
  renderWithout?: string,
): void {
  if (renderWithout && document.getElementById(renderWithout)) {
    return;
  }
  const rootElement = document.getElementById(htmlId) as HTMLElement;
  if (rootElement) {
    const root = ReactDOM.createRoot(rootElement);
    root.render(<>{ReactNodeChildren}</>);
  }
}

export default RenderRootById;
