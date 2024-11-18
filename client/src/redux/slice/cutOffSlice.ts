import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import axios from "axios";
import getAxiosInstance from "src/services/axios";
import HTTPMethod from "http-method-enum";

export interface Cutoff {
  id: number;
  name: string;
  start_date: number;
  end_date: number;
}

export interface CutoffState {
  cutoffs: Cutoff[];
  loading: boolean;
  error: string | null;
}

const initialState: CutoffState = {
  cutoffs: [],
  loading: false,
  error: null,
};

export const fetchCutoffs = createAsyncThunk<Cutoff[], void>(
  "cutoffs/fetchCutoffs",
  async () => {
    const response = await getAxiosInstance().get<Cutoff[]>("/api/cutoff");
    return response.data;
  },
);

// Save a new cutoff
export const saveCutOff = createAsyncThunk<Cutoff, Cutoff>(
  "cutoffs/saveCutOff",
  async (newCutoff) => {
    const response = await getAxiosInstance().post<Cutoff>(
      "/api/cutoff",
      newCutoff,
    );
    return response.data;
  },
);

// Update an existing cutoff
export const updateCutOff = createAsyncThunk<Cutoff, Cutoff>(
  "cutoffs/updateCutOff",
  async (updatedCutoff) => {
    const response = await getAxiosInstance().post<Cutoff>(
      `/api/cutoff/${updatedCutoff.id}`,
      { ...updatedCutoff, _method: HTTPMethod.PATCH },
    );
    return response.data;
  },
);

const cutoffSlice = createSlice({
  name: "cutoffs",
  initialState,
  reducers: {},
  extraReducers: (builder) => {
    builder
      .addCase(fetchCutoffs.pending, (state) => {
        state.loading = true;
        state.error = null;
      })
      .addCase(fetchCutoffs.fulfilled, (state, action) => {
        state.loading = false;
        state.cutoffs = action.payload;
      })
      .addCase(fetchCutoffs.rejected, (state, action) => {
        state.loading = false;
        state.error = action.error.message || "Failed to fetch cutoffs";
      });
  },
});

export const selectCutoffs = (state: { cutoffs: CutoffState }) => state.cutoffs;

export default cutoffSlice.reducer;
