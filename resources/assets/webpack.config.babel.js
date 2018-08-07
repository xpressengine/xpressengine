import path from 'path'
import webpack from 'webpack'
import CopyWebpackPlugin from 'copy-webpack-plugin'

const pathInfo = {
  root: path.resolve(__dirname, '../../'),
  core: path.resolve(__dirname, './core'),
  vendor: path.resolve(__dirname, '../../assets/vendor'),
  node: path.resolve(__dirname, 'node_modules'),

  user: path.resolve(__dirname, './core/user'), // @DEPRECATED
  settings: path.resolve(__dirname, './core/settings'), // @DEPRECATED
  common: path.resolve(__dirname, './core/common'), // @DEPRECATED
  permission: path.resolve(__dirname, './core/permission'), // @DEPRECATED
  menu: path.resolve(__dirname, './core/menu'), // @DEPRECATED
  lang: path.resolve(__dirname, './core/lang'), // @DEPRECATED
  comp: path.resolve(__dirname, './core/xe-ui-component') // @DEPRECATED
}

const resolveAlias = {
  // directory
  'xe': pathInfo.core,

  'xeAssets': path.resolve(__dirname, '../../assets/'), // @DEPRECATED
  'xe-assets': path.resolve(__dirname, './core/'), // @DEPRECATED
  'xe-common': path.resolve(__dirname, './core/common/js/'), // @DEPRECATED
  'xe-vendor': path.resolve(__dirname, '../../assets/vendor/'), // @DEPRECATED
  'xe-component': path.resolve(__dirname, './core/xe-ui-component/js/'), // @DEPRECATED

  'griper': pathInfo.common + '/js/griper.js', // @DEPRECATED
  'validator': pathInfo.common + '/js/validator.js', // @DEPRECATED

  'xe-transition': pathInfo.comp + '/js/xe-transition.js', // @DEPRECATED
  'xe-dropdown': pathInfo.comp + '/js/xe-dropdown.js', // @DEPRECATED
  'xe-modal': pathInfo.comp + '/js/xe-modal.js', // @DEPRECATED
  'xe-tooltip': pathInfo.comp + '/js/xe-tooltip.js', // @DEPRECATED

  'xe-dynamicLoadManager': pathInfo.common + '/js/dynamicLoadManager.js', // @DEPRECATED
  'xe-utils': pathInfo.core + '/utils/index.js', // @DEPRECATED
  'xe-translator': pathInfo.common + '/js/translator.js', // @DEPRECATED
  'jquery-ui/sortable': pathInfo.node + '/jquery-ui/ui/widgets/sortable.js', // @DEPRECATED
  'jqueryui-nestedsortable': pathInfo.vendor + '/nestedSortable/jquery.mjs.nestedSortable.js' // @DEPRECATED
}

const config = [
  // common, vendor
  {
    entry: {
      'vendor': [
        path.resolve(__dirname, './core/vendor.js')
      ],
      'common': [path.resolve(__dirname, './core/common.js')]
    },
    output: {
      path: pathInfo.root,
      filename: 'assets/[name].js',
      library: '_xe_bundle_[name]',
      libraryTarget: 'umd'
    },
    plugins: [
      new webpack.DllPlugin({
        name: '_xe_bundle_[name]',
        path: path.resolve(__dirname, './[name]-manifest.json')
      }),
      new webpack.ContextReplacementPlugin(/moment[\/\\]locale$/, /ko/), // eslint-disable-line
      new webpack.optimize.CommonsChunkPlugin({
        names: ['common', 'vendor']
      })
    ],
    module: {
      rules: [
        {
          test: /(\.js)$/,
          exclude: /node_modules/,
          use: {
            loader: 'babel-loader'
          }
        },
        {
          test: require.resolve('jquery'),
          use: [
            {loader: 'expose-loader', options: 'jQuery'},
            {loader: 'expose-loader', options: '$'}
          ]
        }
      ]
    },
    resolve: {
      alias: resolveAlias,
      extensions: ['.js']
    },
    externals: {
      window: 'window'
    }
  },

  // ALL
  {
    entry: {
      'core/common/js/xe.bundle': [
        pathInfo.common + '/js/xe.js',
        pathInfo.common + '/js/lang.js',
        pathInfo.common + '/js/progress.js',
        pathInfo.common + '/js/request.js',
        pathInfo.common + '/js/component.js'
      ],

      'core/editor/editor.bundle': [
        pathInfo.core + '/editor/editor.core.js',
        pathInfo.core + '/editor/textarea.define.js'
      ],

      'core/permission/permission.bundle': [
        pathInfo.permission + '/permission.js'
      ],

      'core/lang/langEditorBox.bundle': [pathInfo.lang + '/LangEditorBox.js'],
      'core/common/js/dynamicField': [pathInfo.common + '/js/dynamicField'],
      'core/common/js/storeCategory': [pathInfo.common + '/js/storeCategory.js'],
      'core/user/settings/edit': [pathInfo.user + '/settings/edit.js'],
      'core/settings/js/admin.bundle': [pathInfo.settings + '/js/admin.js'],

      // gulp assets:tree
      // @FIXME
      // @DEPRECATED
      'core/common/js/xe.tree': [pathInfo.core + '/tree/Tree.js']
    },
    output: {
      path: pathInfo.root,
      filename: 'assets/[name].js',
      libraryTarget: 'umd'
    },
    plugins: [
      new CopyWebpackPlugin([
        {
          context: path.core,
          from: './core/**/*',
          to: path.resolve(__dirname, '../../assets'),
          ignore: [
            '**/*.scss',
            'core/common.js',
            'core/common/js/component.js',
            'core/common/js/draft.js',
            'core/common/js/dynamicField.js',
            'core/common/js/dynamicLoadManager.js',
            'core/common/js/griper.js',
            'core/common/js/lang.js',
            'core/common/js/progress.js',
            'core/common/js/request.js',
            'core/common/js/storeCategory.js',
            'core/common/js/translator.js',
            'core/common/js/utils.js',
            'core/common/js/validator.js',
            'core/common/js/xe.js',
            'core/component.js',
            'core/dynamic-load-manager.js',
            'core/editor/**/*.js',
            'core/error/index.js',
            'core/validator/index.js',
            'core/gulpfile.babel.js',
            'core/index.js',
            'core/karma.conf.js',
            'core/lang.js',
            'core/lang/LangEditorBox.js',
            'core/node_modules/**/*',
            'core/package.json',
            'core/permission/*.js',
            'core/request/**/*.js',
            'core/router/**/*.js',
            'core/settings/js/admin.js',
            'core/singleton.js',
            'core/tree/**/*.js',
            'core/user/settings/edit.js',
            'core/utils/**/*.js',
            'core/vendor.js',
            'core/webpack.config.babel.js'
          ]
        }
      ]),
      new webpack.ContextReplacementPlugin(/moment[\/\\]locale$/, /ko/), // eslint-disable-line
      new webpack.DllReferencePlugin({
        context: '.',
        manifest: path.resolve(__dirname, './vendor-manifest.json')
      }),
      new webpack.DllReferencePlugin({
        context: '.',
        manifest: path.resolve(__dirname, './common-manifest.json')
      })
    ],
    module: {
      rules: [
        {
          test: /(\.js)$/,
          exclude: /node_modules/,
          use: {
            loader: 'babel-loader'
          }
        },
        {
          test: /\.css$/,
          loaders: [
            {loader: 'file-loader'},
            {loader: 'extract-loader'},
            {loader: 'css-loader'}
          ]
        }
      ]
    },
    resolve: {
      alias: resolveAlias,
      extensions: ['.js']
    },
    externals: {
      window: 'window'
    }
  }
]

export {
  config as default,
  pathInfo,
  resolveAlias
}
