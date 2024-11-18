/* eslint-disable */
const CracoLessPlugin = require("craco-less");
const path = require("path");

module.exports = {
  plugins: [
    {
      plugin: CracoLessPlugin,
      options: {
        lessLoaderOptions: {
          lessOptions: {
            modifyVars: {},
            javascriptEnabled: true,
          },
        },
      },
    },
  ],

  webpack: {
    alias: {
      src: path.resolve(__dirname, "src"),
      "@": path.resolve(__dirname, "src"),
    },
  },
};
