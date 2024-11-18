import { createSlice, PayloadAction } from "@reduxjs/toolkit";
import { RootState } from "src/redux/store";

interface BulkUploadState {
  count: number;
}

const initialState: BulkUploadState = {
  count: 0,
};

const bulkUploadStateSlice = createSlice({
  name: "bulkUploadCounter",
  initialState,
  reducers: {
    setUploadCount: (state, action: PayloadAction<number>) => {
      state.count = action.payload;
    },
    incrementUploadCount(state) {
      state.count += 1;
    },
    resetUploadCount(state) {
      state.count = 0;
    },
  },
});

export const { incrementUploadCount, resetUploadCount, setUploadCount } =
  bulkUploadStateSlice.actions;

export const getBulkUploadState = (state: RootState) => state.bulkUploadState;

export default bulkUploadStateSlice.reducer;
