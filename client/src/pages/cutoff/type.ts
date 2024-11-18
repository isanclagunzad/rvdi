import { Cutoff } from "src/redux/slice/cutOffSlice";

export interface CutOffRow extends Cutoff {
  actions?: string;
}

export interface CutOffFormData {
  id?: number;
  name?: string;
  start_date?: number;
  end_date?: number;
}
