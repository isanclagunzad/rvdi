import React from "react";
import "./App.scss";
import AppRouter from "./AppRouter";
import { Provider } from "react-redux";
import store from "src/redux/store";

function App() {
  return (
    <Provider store={store}>
      <AppRouter />
    </Provider>
  );
}

export default App;
