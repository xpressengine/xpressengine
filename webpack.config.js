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
};

var target = (process.env.npm_lifecycle_event === 'build')? true : !!$.util.env.production;

var common = {
  entry: {
    'vendor': ['react', 'react-dom', 'moment'],
    'assets/core/permission/permission.bundle': [
     pathInfo.permission + '/Permission.jsx',
     pathInfo.permission + '/PermissionExclude.jsx',
     pathInfo.permission + '/PermissionInclude.jsx',
     pathInfo.permission + '/PermissionRadioComp.jsx',
     pathInfo.permission + '/PermissionRenderer.jsx',
     pathInfo.permission + '/PermissionTag.jsx',
     pathInfo.permission + '/PermissionTagSuggestion.jsx',
     pathInfo.permission + '/SettingsPermission.jsx',
    ],
    'assets/core/menu/menu.bundle': [
     pathInfo.menu + '/MenuRenderer.js',
     pathInfo.menu + '/MenuEntity.js',
     pathInfo.menu + '/MenuItem.js',
     pathInfo.menu + '/TreeNode.js',
     pathInfo.menu + '/MenuSearchBar.js',
     pathInfo.menu + '/UITree.js',
     pathInfo.menu + '/MenuSearchBar.js',
     pathInfo.menu + '/MenuSearchSuggestion.js',
     pathInfo.menu + '/MenuTree.js',
    ],

    'assets/core/common/js/xe.bundle': [
      pathInfo.common + '/js/xe.js',
      pathInfo.common + '/js/xe.lang.js',
      pathInfo.common + '/js/xe.progress.js',
      pathInfo.common + '/js/xe.request.js',
      pathInfo.common + '/js/xe.component.js',
    ],

    'assets/core/lang/langEditorBox.bundle': pathInfo.lang + '/LangEditorBox.js',
    'assets/core/common/js/griper': pathInfo.common + '/js/griper',
    'assets/core/common/js/validator': pathInfo.common + '/js/validator',
    'assets/core/common/js/toggleMenu': pathInfo.common + '/js/toggleMenu',
    'assets/core/common/js/dynamicField': pathInfo.common + '/js/dynamicField',
    'assets/core/common/js/storeCategory': pathInfo.common + '/js/storeCategory.js',
    'assets/core/common/js/rule': pathInfo.common + '/js/rule.js',
    'assets/core/member/settings/edit': pathInfo.member + '/settings/edit.js',
    'assets/core/settings/js/admin.bundle': pathInfo.settings + '/js/admin.js',
  },
  output: {
    path: path.resolve(__dirname, './'),
    filename: '[name].js',
  },
  plugins: [
    new CommonsChunkPlugin('vendor', 'assets/vendor/vendor.bundle.js'),
  ],
  module: {
    loaders: [
     {
      test: /(\.js|\.jsx)$/,
      loader: 'babel-loader',
      exclude: /node_modules/,
      query: {
        presets: ['es2015', 'react'],
        cacheDirectory: true,
      },
    },
    ],
  },
  resolve: {
    alias: {
      'xe': pathInfo.core + '/common/js/xe.js',
      'griper': pathInfo.core + '/common/js/griper.js',
      'validator': pathInfo.core + '/common/js/validator.js',

      'xe-transition': pathInfo.core + '/xe-ui-component/js/xe-transition.js',
      'xe-dropdown': pathInfo.core + '/xe-ui-component/js/xe-dropdown.js',
      'xe-modal': pathInfo.core + '/xe-ui-component/js/xe-modal.js',
      'xe-tooltip': pathInfo.core + '/xe-ui-component/js/xe-tooltip.js',

      'vendor': pathInfo.vendor + '/vendor.bundle.js',
    },
    extensions: ['', '.js', '.jsx'],
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
