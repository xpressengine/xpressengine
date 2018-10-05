require('babel-core/register')
var resolveAlias = require('./webpack.config.babel').resolveAlias

module.exports = function (config) {
  config.set({
    // base path that will be used to resolve all patterns (eg. files, exclude)
    basePath: '',

    // frameworks to use
    // available frameworks: https://npmjs.org/browse/keyword/karma-adapter
    frameworks: ['mocha', 'jquery-3.2.1'],

    // list of files / patterns to load in the browser
    files: [
      'tests/**/*.spec.js'
    ],

    // plugins: ['karma-coverage-istanbul-reporter'],

    // list of files / patterns to exclude
    exclude: [
    ],

    // preprocess matching files before serving them to the browser
    // available preprocessors: https://npmjs.org/browse/keyword/karma-preprocessor
    preprocessors: {
      'core/**/*.js': ['webpack', 'coverage'],
      'tests/**/*.js': ['webpack']
    },

    // test results reporter to use
    // possible values: 'dots', 'progress'
    // available reporters: https://npmjs.org/browse/keyword/karma-reporter
    reporters: ['mocha', 'coverage-istanbul'],

    // web server port
    port: 9876,

    // enable / disable colors in the output (reporters and logs)
    colors: true,

    // level of logging
    // possible values: config.LOG_DISABLE || config.LOG_ERROR || config.LOG_WARN || config.LOG_INFO || config.LOG_DEBUG
    logLevel: config.LOG_INFO,

    // enable / disable watching file and executing tests whenever any file changes
    autoWatch: true,

    // start these browsers
    // available browser launchers: https://npmjs.org/browse/keyword/karma-launcher
    browsers: ['jsdom'],

    // Continuous Integration mode
    // if true, Karma captures browsers, runs the tests and exits
    singleRun: false,

    // Concurrency level
    // how many browser should be started simultaneous
    concurrency: Infinity,

    webpack: {
      module: {
        loaders: [
          {
            test: /\.js$/,
            exclude: /node_modules|\.spec\.js$|tests|translator\.js|xe-ui-component\/js|_deprecated\.js/,
            loader: 'babel-loader?presets[]=env'
          }
        ]
      },
      resolve: {
        alias: resolveAlias
      },
      watch: true
    },
    webpackServer: {
      noInfo: true
    }
  })
}
