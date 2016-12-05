var webpack = require('webpack');

module.exports = {
  devtool: 'source-map',
  plugins: [
   new webpack.NoErrorsPlugin(),
   new webpack.optimize.DedupePlugin(), //중복 모듈 제거
   new webpack.optimize.UglifyJsPlugin({ minimize: true, compress: { warnings: false }, sourceMap: false }),   //uglify, minify
   new webpack.DefinePlugin({
    'process.env': {
      // This has effect on the react lib size
      NODE_ENV: JSON.stringify('production'),
    },
  }),
  ],
};
