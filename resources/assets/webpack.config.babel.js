import path from 'path'
import webpack from 'webpack'
import CopyWebpackPlugin from 'copy-webpack-plugin'
import { pathInfo, resolveAlias } from './dll.webpack.config.babel'

export default {
  mode: 'production',
  target: 'web',
  entry: {
    'core/common/js/xe.bundle': [
      'xe',
      pathInfo.common + '/js/lang.js',
      pathInfo.common + '/js/progress.js',
      pathInfo.common + '/js/request.js',
      pathInfo.common + '/js/component.js'
    ],

    'core/editor/editor.bundle': [
      pathInfo.core + '/editor/index',
      pathInfo.core + '/editor/textarea.define.js'
    ],

    'core/common/js/draft': pathInfo.common + '/js/draft.js',
    'core/common/js/dynamicField': pathInfo.common + '/js/dynamicField',
    'core/common/js/storeCategory': pathInfo.common + '/js/storeCategory.js',
    'core/lang/langEditorBox.bundle': pathInfo.lang + '/LangEditorBox.js',
    'core/permission/permission.bundle': pathInfo.permission + '/permission.js',
    'core/settings/js/admin.bundle': pathInfo.settings + '/js/admin.js',
    'core/user/settings/edit': pathInfo.user + '/settings/edit.js',

    // gulp assets:tree
    // @FIXME
    // @DEPRECATED
    'core/common/js/xe.tree': pathInfo.core + '/tree/Tree.js'
  },
  output: {
    path: pathInfo.root,
    filename: 'assets/[name].js'
  },
  plugins: [
    new webpack.DllReferencePlugin({
      manifest: path.resolve(__dirname, './vendor-manifest.json')
    }),
    new webpack.DllReferencePlugin({
      manifest: path.resolve(__dirname, './common-manifest.json')
    }),
    new CopyWebpackPlugin([
      {
        context: path.core,
        from: './core/**/*',
        to: path.resolve(__dirname, '../../assets'),
        ignore: [
          '**/*.scss',
          '**/*.vue',
          'core/**/errors/*.error.js',
          'core/**/index.js',
          'core/**/store.js',
          'core/app.js',
          'core/aspect.js',
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
          'core/form/**/*.js',
          'core/griper/**/*.js',
          'core/index.js',
          'core/karma.conf.js',
          'core/lang/index.js',
          'core/lang/LangEditorBox.js',
          'core/permission/*.js',
          'core/plugin.js',
          'core/request/**/*.js',
          'core/router/**/*.js',
          'core/settings/js/admin.js',
          'core/singleton.js',
          'core/tree/**/*.js',
          'core/user/settings/edit.js',
          'core/utils/**/*.js',
          'core/validator/**/*.js',
          'core/vendor.js'
        ]
      }
    ])
  ],
  module: {
    rules: [
      {
        test: /(\.js)$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader'
        }
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

export {
  pathInfo,
  resolveAlias
}
