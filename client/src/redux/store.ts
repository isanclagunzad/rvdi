// src/redux/store.ts
import { configureStore } from "@reduxjs/toolkit";
import bulkUploadStateSlice from "src/redux/slice/bulkUploadStateSlice";
import employeeSlice from "src/redux/slice/employeeSlice";
import customFieldsSlice from "src/redux/slice/customFieldsSlice";
import { TypedUseSelectorHook, useDispatch, useSelector } from "react-redux";
import cutOffSlice from "src/redux/slice/cutOffSlice";

const store = configureStore({
  reducer: {
    bulkUploadState: bulkUploadStateSlice,
    employeeState: employeeSlice,
    customFieldsState: customFieldsSlice,
    cutoffs: cutOffSlice,
  },
});

// Infer the `RootState` and `AppDispatch` types from the store itself
export type RootState = ReturnType<typeof store.getState>;
export type AppDispatch = typeof store.dispatch;

// Create typed versions of useDispatch and useSelector
export const useAppDispatch = () => useDispatch<AppDispatch>();
export const useAppSelector: TypedUseSelectorHook<RootState> = useSelector;

export default store;
