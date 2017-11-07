import gulp from 'gulp';
import plugins from 'gulp-load-plugins';
import webpack from 'webpack-stream';
import webpackConfig from '../../webpack.config.js';

module.exports = (() => {
  'use strict';

  const $ = plugins();

  return {
    'webpack': (callback) => {
      return gulp.src([])
        .pipe(webpack(webpackConfig))
        .pipe(gulp.dest('./'));
    },
  };
})();
