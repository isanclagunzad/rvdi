export interface FileUploadState {
  name: string;
  file: Blob;
  progress?: number;
  uploaded: boolean;
}
