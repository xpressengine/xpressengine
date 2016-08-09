
'use strict';

import gulp from 'gulp';
import plugins from 'gulp-load-plugins';
import runSequence from 'run-sequence';
import elixir from 'laravel-elixir';
import merge from 'merge-stream';
import settings from './resources/gulpTasks/settings';
import taskReact from './resources/gulpTasks/react';
import taskCss from './resources/gulpTasks/css';

const $ = plugins();

gulp.task('default', function(callback){
  runSequence(
      'clean:assets',
      'copy:assets',
      'jspm:menu',
      'jspm:langbox',
      'jsx:permission',
      'jspm:component',
      'jspm:xe',
      'assets:sass',
      callback);
});

// s: settings
gulp.task('clean:assets', settings['clean:assets']);
gulp.task('copy:assets', settings['copy:assets']);

gulp.task('jspm:xe', settings['jspm:xe']);
gulp.task('jspm:component', settings['jspm:component']);
// e: settings

// s: react
gulp.task('jspm:menu', taskReact['jspm:menu']);
gulp.task('jspm:langbox', taskReact['jspm:langbox']);
gulp.task('jsx:permission', taskReact['jsx:permission']);
gulp.task('watch:react', () => {
  return gulp.watch([
    './resources/assets/core/menu/**',
    './resources/assets/core/lang/**',
    './resources/assets/core/permission/**'
  ], ['react']);
});

gulp.task('react', (callback) => {
  runSequence(
      'jspm:menu',
      'jspm:langbox',
      'jsx:permission',
      'watch:react',
      callback);
});
// e: react

// s: css
gulp.task('assets:sass', taskCss['assets:sass']);
// e: css























//
// gulp.task('watch', function() {
//   gulp.watch(['./resources/assets/**'], ['default']);
// });
//
// gulp.task('assets:csscomb', function() {
//   return gulp.src('./resources/assets/**/*.scss')
//     .pipe($.plumber())
//     .pipe($.csscomb())
//     .pipe(gulp.dest('./resources/assets/'));
// });
//
//
// gulp.task('csslint', function() {
//   gulp.src('./resources/assets/core/**/*.css')
//     .pipe($.plumber())
//     .pipe($.csslint())
//     .pipe($.csslint.reporter());
// });
//
// /* lint */
// var lint_ignore = ['**/bower_components/**', '**/*.min.*'];
// gulp.task('lint', ['lint:sass', 'lint:css', 'lint:js']);
//
// gulp.task('lint:sass', function () {
//   return gulp.src('resources/assets/**/*.s+(a|c)ss')
//     .pipe($.plumber())
//     .pipe($.ignore.exclude(lint_ignore))
//     .pipe($.sassLint())
//     .pipe($.sassLint.format())
//     .pipe($.sassLint.failOnError())
// });
//
// gulp.task('lint:css', function() {
//   return gulp.src('./resources/assets/**/*.css')
//     .pipe($.plumber())
//     .pipe($.ignore.exclude(lint_ignore))
//     .pipe($.csslint())
//     .pipe($.csslint.reporter('compact'));
// });
//
// gulp.task('lint:js', function() {
//   return gulp.src('resources/assets/**/*.js')
//     .pipe($.plumber())
//     .pipe($.ignore.exclude(lint_ignore))
//     .pipe($.jshint())
//     .pipe($.jshint.reporter())
//     .pipe($.jshint.reporter('fail'));
// });
// /* END:lint */
//
// gulp.task('jspm-assets', function() {
//   var assets = [];
//
//   // jQuery
//   assets.push($.jspmAssets.jspmAssets({
//       'jquery': '**/*',
//       'jquery-migrate': 'dist/jquery-migrate.min.js'
//     })
//   // normalize
//     .pipe(gulp.dest('./assets/vendor/jquery')));
//   assets.push($.jspmAssets.jspmAssets('normalize.css', 'normalize.css')
//     .pipe(gulp.dest('./assets/vendor/normalize')));
//   // Swiper@^2
//   assets.push($.jspmAssets.jspmAssets('swiper2', 'dist/*')
//     .pipe(gulp.dest('./assets/vendor/swiper2')));
//   // blueimp-file-upload
//   // assets.push($.jspmAssets.jspmAssets('blueimp-file-upload', '**/*')
//   //   .pipe(gulp.dest('./assets/vendor/blueimp-file-upload')));
//   // lodash
//   assets.push($.jspmAssets.jspmAssets('lodash', 'lodash.min.js')
//     .pipe(gulp.dest('./assets/vendor/lodash')));
//   // moment
//   assets.push($.jspmAssets.jspmAssets('moment', 'moment.js')
//     .pipe($.uglify())
//     .pipe($.rename('moment.min.js'))
//     .pipe(gulp.dest('./assets/vendor/moment')));
//   assets.push($.jspmAssets.jspmAssets('moment', 'locale/*')
//     .pipe($.uglify())
//     .pipe(gulp.dest('./assets/vendor/moment/locale')));
//
//   return merge(assets);
// });
