module.exports = {
  premodule: {
    rules: [
    ],
    stories: [],
    addons: [],
  },
  module: {
    rules: [
      {
        test: /\.(svg|png|jpe?g|gif)$/i,
        use: [
          {
            loader: 'file-loader',
          },
         ]
       }
    ],
    stories: [],
    addons: [],
  },
};
