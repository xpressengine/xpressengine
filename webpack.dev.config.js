var webpack = require('webpack');

module.exports = {
  devtool: 'eval',
  plugins: [
    new webpack.HotModuleReplacementPlugin()
  ],
};
