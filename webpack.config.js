var path = require('path');
var webpack = require('webpack');
var webpackMerge = require('webpack-merge');
var $ = require('gulp-load-plugins')();

var CommonsChunkPlugin = require('webpack/lib/optimize/CommonsChunkPlugin');

var prodConfig = require('./webpack.prod.config');
var devConfig = require('./webpack.dev.config');

var pathInfo = {
  vendor: path.join(__dirname, '/assets/vendor'),
  node: path.join(__dirname, '/node_modules'),
  core: path.join(__dirname, '/assets/core'),
  member: path.join(__dirname, '/resources/assets/core/member'),
  settings: path.join(__dirname, '/resources/assets/core/settings'),
  common: path.join(__dirname, '/resources/assets/core/common'),
  permission: path.join(__dirname, '/resources/assets/core/permission'),
  menu: path.join(__dirname, '/resources/assets/core/menu'),
  lang: path.join(__dirname, '/resources/assets/core/lang'),
  comp: path.join(__dirname, '/resources/assets/core/xe-ui-component'),
};

var target = (process.env.npm_lifecycle_event === 'build')? true : !!$.util.env.production;

var common = {
  entry: {
    'assets/core/common/js/xe.bundle': [
      pathInfo.common + '/js/xe.js',
      pathInfo.common + '/js/xe.lang.js',
      pathInfo.common + '/js/xe.progress.js',
      pathInfo.common + '/js/xe.request.js',
      pathInfo.common + '/js/xe.component.js',
    ],

    'assets/core/permission/permission.bundle': [
      pathInfo.permission + '/permission.js',
    ],

    'assets/core/lang/langEditorBox.bundle': pathInfo.lang + '/LangEditorBox.js',
    'assets/core/common/js/dynamicField': pathInfo.common + '/js/dynamicField',
    'assets/core/common/js/storeCategory': pathInfo.common + '/js/storeCategory.js',
    'assets/core/member/settings/edit': pathInfo.member + '/settings/edit.js',
    'assets/core/settings/js/admin.bundle': pathInfo.settings + '/js/admin.js',
  },
  output: {
    path: path.resolve(__dirname, './'),
    filename: '[name].js',
  },
  plugins: [],
  module: {
    rules: [{
     test: /(\.js|\.jsx)$/,
     exclude: /node_modules/,
     use: {
       loader: 'babel-loader',
       options: {
         cacheDirectory: true,
         presets: ['es2015'],
       },
     },
    }],
  },
  resolve: {
    alias: {
      'xe': pathInfo.common + '/js/xe.js',
      'griper': pathInfo.common + '/js/griper.js',
      'validator': pathInfo.common + '/js/validator.js',

      'xe-transition': pathInfo.comp + '/js/xe-transition.js',
      'xe-dropdown': pathInfo.comp + '/js/xe-dropdown.js',
      'xe-modal': pathInfo.comp + '/js/xe-modal.js',
      'xe-tooltip': pathInfo.comp + '/js/xe-tooltip.js',

      'vendor': pathInfo.vendor + '/vendor.bundle.js',
    },
    extensions: ['.js', '.jsx'],
  },
  externals: {
    window: 'window',
  },
};

var config;

if (target) {
  config = webpackMerge(common, prodConfig);
} else {
  config = webpackMerge(common, devConfig);
}

module.exports = config;
