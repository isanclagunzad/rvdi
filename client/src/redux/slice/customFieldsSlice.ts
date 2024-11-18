// src/features/customFields/customFieldsSlice.ts

import { createSlice, createAsyncThunk, PayloadAction } from "@reduxjs/toolkit";
import getAxiosInstance from "src/services/axios";

export interface CustomField {
  id?: number;
  name: string;
  value: any;
  // Add other fields as necessary
}

interface CustomFieldsState {
  customFields: CustomField[];
  loading: boolean;
  error: string | null;
}

const initialState: CustomFieldsState = {
  customFields: [],
  loading: false,
  error: null,
};

interface GetCustomFieldsParams {
  employeeId: number;
}

export const getCustomFields = createAsyncThunk<
  CustomField[],
  GetCustomFieldsParams,
  { rejectValue: string }
>("customFields/getCustomFields", async ({ employeeId }, thunkAPI) => {
  try {
    const response = await getAxiosInstance().get(
      `/api/employee/${employeeId}/custom-fields`,
    );
    return response.data;
  } catch (error: any) {
    return thunkAPI.rejectWithValue(error.message);
  }
});

const customFieldsSlice = createSlice({
  name: "customFields",
  initialState,
  reducers: {},
  extraReducers: (builder) => {
    builder
      .addCase(getCustomFields.pending, (state) => {
        state.loading = true;
        state.error = null;
      })
      .addCase(
        getCustomFields.fulfilled,
        (state, action: PayloadAction<CustomField[]>) => {
          state.customFields = action.payload;
          state.loading = false;
        },
      );
  },
});

export default customFieldsSlice.reducer;
