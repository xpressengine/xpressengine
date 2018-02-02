const path = require('path')
const webpack = require('webpack')
const webpackMerge = require('webpack-merge')
const CopyWebpackPlugin = require('copy-webpack-plugin')

const prodConfig = require('./webpack.prod.config')
const devConfig = require('./webpack.dev.config')

const pathInfo = {
  vendor: path.join(__dirname, '/assets/vendor'),
  node: path.join(__dirname, '/node_modules'),
  core: path.join(__dirname, '/resources/assets/core'),
  member: path.join(__dirname, '/resources/assets/core/member'),
  settings: path.join(__dirname, '/resources/assets/core/settings'),
  common: path.join(__dirname, '/resources/assets/core/common'),
  permission: path.join(__dirname, '/resources/assets/core/permission'),
  menu: path.join(__dirname, '/resources/assets/core/menu'),
  lang: path.join(__dirname, '/resources/assets/core/lang'),
  comp: path.join(__dirname, '/resources/assets/core/xe-ui-component')
}

const common = {
  entry: {
    'assets/core/common/js/xe.bundle': [
      pathInfo.common + '/js/xe.js',
      pathInfo.common + '/js/xe.lang.js',
      pathInfo.common + '/js/xe.progress.js',
      pathInfo.common + '/js/xe.request.js',
      pathInfo.common + '/js/xe.component.js'
    ],

    'assets/core/permission/permission.bundle': [
      pathInfo.permission + '/permission.js'
    ],

    'assets/core/lang/langEditorBox.bundle': pathInfo.lang + '/LangEditorBox.js',
    'assets/core/common/js/dynamicField': pathInfo.common + '/js/dynamicField',
    'assets/core/common/js/storeCategory': pathInfo.common + '/js/storeCategory.js',
    'assets/core/member/settings/edit': pathInfo.member + '/settings/edit.js',
    'assets/core/settings/js/admin.bundle': pathInfo.settings + '/js/admin.js',

    // gulp assets:chunk
    // @FIXME
    // @DEPRECATED
    'assets/bundle': path.join(__dirname, '/resources/assets') + '/bundle.js',

    // gulp assets:tree
    // @FIXME
    // @DEPRECATED
    'assets/core/common/js/xe.tree': pathInfo.core + '/tree/Tree.js',

    // gulp assets:draft
    // @FIXME
    // @DEPRECATED
    // 현재 사용 안 됨 https://github.com/xpressengine/plugin-board/commit/7b2ae1a6
    'assets/core/common/js/draft.bundle': [
      pathInfo.vendor + '/bootstrap/js/collapse.js',
      pathInfo.common + '/js/draft.js'
    ]
  },
  output: {
    path: path.resolve(__dirname, './'),
    filename: '[name].js'
  },
  plugins: [
    new CopyWebpackPlugin([
      {
        context: './resources/assets/core',
        from: '**/*',
        to: './assets/core',
        ignore: [
          '**/*.scss',
          '**/img/*',
          'common/js/dynamicField.js',
          'common/js/dynamicLoadManager.js',
          'common/js/griper.js',
          'common/js/storeCategory.js',
          'common/js/translator.js',
          'common/js/utils.js',
          'common/js/validator.js',
          'common/js/xe.js',
          'common/js/xe.component.js',
          'common/js/xe.lang.js',
          'common/js/xe.progress.js',
          'common/js/xe.request.js',
          'lang/LangEditorBox.js',
          'permission/*.js',
          'settings/js/admin.js',
          'member/settings/edit.js',
          'tree/*.js'
        ]
      }
    ])
  ],
  module: {
    rules: [
      {
        test: /(\.js|\.jsx)$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            cacheDirectory: true,
          }
        }
      },
      {
        test: /\.scss$/,
        use: [{
          loader: 'style-loader' // creates style nodes from JS strings
        },
        {
          loader: 'css-loader' // translates CSS into CommonJS
        },
        {
          loader: 'sass-loader', // compiles Sass to CSS
          options: {
            includePaths: ['./resources/assets/core/**/*', './assets/core']
          }
        }]
      },
      {
        test: require.resolve('jquery'),
        use: [
          {loader: 'expose-loader', options: 'jQuery'},
          {loader: 'expose-loader', options: '$'}
        ]
      },
      {
        test: require.resolve('blankshield'),
        use: {loader: 'expose-loader', options: 'blankshield'}
      },
      {
        test: require.resolve('moment'),
        use: {loader: 'expose-loader', options: 'moment'}
      }
    ]
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

      // 'vendor': pathInfo.vendor + '/vendor.bundle.js',
      'xe-dynamicLoadManager': pathInfo.common + '/js/dynamicLoadManager.js', // @FIXME
      'xe-utils': pathInfo.common + '/js/utils.js', // @FIXME
      'xe-translator': pathInfo.common + '/js/translator.js', // @FIXME
      'jqueryui-sortable': pathInfo.vendor + '/jqueryui/jquery-ui.sortable.js', // @FIXME
      'jqueryui-nestedsortable': pathInfo.vendor + '/nestedSortable/jquery.mjs.nestedSortable.js' // @FIXME
    },
    extensions: ['.js', '.jsx']
  },
  externals: {
    window: 'window'
  }
}

var config

if (process.env) {
  config = webpackMerge(common, prodConfig)
} else {
  config = webpackMerge(common, devConfig)
}

module.exports = config
