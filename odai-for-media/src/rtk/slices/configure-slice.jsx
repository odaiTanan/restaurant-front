import { createSlice } from "@reduxjs/toolkit";

const configureSlice = createSlice({
  initialState: "http://localhost/restaurant/",
  name: "configureSlice",
  reducers: {},
});

export const {} = configureSlice.actions;
export default configureSlice.reducer;
