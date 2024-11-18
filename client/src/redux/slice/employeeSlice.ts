import { createSlice, createAsyncThunk, PayloadAction } from "@reduxjs/toolkit";
import getAxiosInstance from "src/services/axios";

interface EmployeeState {
  srcCode: string;
  loading: boolean;
  error: string | null;
}

export const SRC_CODE = "src_code";
export const BNR_FILES = "bnr_files";

const initialState: EmployeeState = {
  srcCode: "",
  loading: false,
  error: null,
};

interface CustomFieldParams {
  employeeId: number;
  srcCode?: number;
  customFieldId?: number;
  file?: Blob;
  name: string;
  value: any;
}

export const addCustomField = createAsyncThunk<string, CustomFieldParams>(
  "employee/addCustomField",
  async ({ employeeId, name, value }: CustomFieldParams, thunkAPI) => {
    try {
      const url = `/api/employee/${employeeId}/custom-fields`;
      if (typeof value !== "object") {
        const response = await getAxiosInstance().post(url, {
          name,
          value: String(value),
        });
        return response.data;
      }
      if (value && typeof value === "object") {
        const formData = new FormData();
        formData.append("name", name);
        formData.append("file", value);
        const response = await getAxiosInstance().post(url, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });
        return response.data;
      }
    } catch (error: any) {
      return thunkAPI.rejectWithValue(error.response.data);
    }
  },
);

export const updateCustomField = createAsyncThunk<string, CustomFieldParams>(
  "employee/updateCustomField",
  async (
    { employeeId, name, value, customFieldId }: CustomFieldParams,
    thunkAPI,
  ) => {
    try {
      const url = `/api/employee/${employeeId}/custom-field-value/${customFieldId}/update`;
      if (typeof value !== "object") {
        const response = await getAxiosInstance().patch(url, {
          name,
          value: String(value),
        });
        return response.data;
      }
      if (value && typeof value === "object") {
        const formData = new FormData();
        formData.append("name", name);
        formData.append("file", value);
        const response = await getAxiosInstance().post(url, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });
        return response.data;
      }
    } catch (error: any) {
      return thunkAPI.rejectWithValue(error.response.data);
    }
  },
);

const employeeSlice = createSlice({
  name: "employee",
  initialState,
  reducers: {},
  extraReducers: (builder) => {
    builder
      .addCase(addCustomField.pending, (state) => {
        state.loading = true;
        state.error = null;
      })
      .addCase(
        addCustomField.fulfilled,
        (state, action: PayloadAction<string>) => {
          state.srcCode = action.payload;
          state.loading = false;
        },
      )
      .addCase(addCustomField.rejected, (state) => {
        state.loading = false;
        state.error = "Error!";
      });
  },
});

export default employeeSlice.reducer;
