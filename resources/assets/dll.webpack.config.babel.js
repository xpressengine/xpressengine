import path from 'path'
import webpack from 'webpack'
import { VueLoaderPlugin } from 'vue-loader'
import sass from 'sass'

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
  'jquery': 'jquery/src/jquery',
  'jquery-ui/sortable': pathInfo.node + '/jquery-ui/ui/widgets/sortable.js', // @DEPRECATED

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
}

export default [
  {
    mode: 'production',
    name: 'vendor',
    target: 'web',
    entry: {
      'vendor': [
        'jquery',
        'jquery-migrate',
        'axios',
        'blankshield',
        'lodash',
        'moment',
        'urijs',
        'vue',
        'vuex'
      ]
    },
    output: {
      path: pathInfo.root,
      filename: 'assets/[name].js',
      library: '_xe_dll_vendor',
      libraryTarget: 'umd'
    },
    plugins: [
      new webpack.DllPlugin({
        name: '_xe_dll_vendor',
        path: path.resolve(__dirname, './[name]-manifest.json')
      }),
      new webpack.ContextReplacementPlugin(/moment[\/\\]locale$/, /ko/) // eslint-disable-line
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
            { loader: 'expose-loader', options: 'jQuery' },
            { loader: 'expose-loader', options: '$' }
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
  {
    mode: 'production',
    name: 'common',
    target: 'web',
    entry: {
      'common': [ path.resolve(__dirname, './core/index.js') ]
    },
    output: {
      path: pathInfo.root,
      filename: 'assets/[name].js',
      library: '_xe_dll_common',
      libraryTarget: 'umd'
    },
    plugins: [
      new webpack.DllReferencePlugin({
        manifest: path.resolve(__dirname, './vendor-manifest.json')
      }),
      new webpack.DllPlugin({
        name: '_xe_dll_common',
        path: path.resolve(__dirname, './[name]-manifest.json')
      }),
      new webpack.ContextReplacementPlugin(/moment[\/\\]locale$/, /ko/), // eslint-disable-line
      new VueLoaderPlugin()
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
          test: /\.vue$/,
          exclude: /node_modules/,
          use: 'vue-loader'
        },
        {
          test: /\.scss$/,
          use: [
            'vue-style-loader',
            'css-loader',
            {
              loader: 'sass-loader',
              options: {
                implementation: sass,
                outputStyle: 'compressed'
              }
            }
          ]
        }
      ]
    },
    resolve: {
      alias: resolveAlias,
      extensions: ['.js', '.json', '.vue']
    },
    externals: {
      window: 'window'
    }
  }
]

export {
  pathInfo,
  resolveAlias
}
