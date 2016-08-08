
'use strict';

import gulp from 'gulp';
import plugins from 'gulp-load-plugins';
import runSequence from 'run-sequence';
import elixir from 'laravel-elixir';
import merge from 'merge-stream';
import settings from './resources/gulpTasks/settings';
import config from './resources/gulpTasks/config';
import taskJsx from './resources/gulpTasks/jsx';

const $ = plugins();

gulp.task('default', function(callback){
  runSequence(
      'clean:assets',
      'copy-assets',
      'assets:sass',
      'jspm:component',
      'jspm:menu',
      'jspm:langbox',
      'jsx:permission',
      'jspm:xe',
      callback);
});

gulp.task('clean:assets', settings['clean:assets']);

gulp.task('copy-assets', settings['copy:assets']);


// // assets 재구성을 위한 임시 task
// elixir(function(mix) {
//   mix.copy('resources/assets/core', 'assets/core');
// });


// gulp.task('jspm', ['copy-assets'], function(callback){
//   runSequence(
//     'jspm:component',
//     'jspm:menu',
//     'jspm:langbox',
//     callback);
// });

gulp.task('jspm:xe', function() {
  return gulp.src(['assets/core/common/js/xe.js', 'assets/core/common/js/translator.js', 'assets/core/common/js/xe.lang.js', 'assets/core/common/js/xe.progress.js', 'assets/core/common/js/xe.request.js', 'assets/core/common/js/xe.component.js'])
    .pipe($.concat('xe.bundle.js'))
    .pipe(gulp.dest('assets/core/common/js/'));
});

gulp.task('jspm:menu', taskJsx['jspm:menu']);
gulp.task('jspm:langbox', taskJsx['jspm:langbox']);
gulp.task('jsx:permission', taskJsx['jsx:permission']);

gulp.task('jsx', (callback) => {
  runSequence(
      'jspm:menu',
      'jspm:langbox',
      'jsx:permission',
      callback);
});

gulp.task('jspm:component', function(){
  return gulp.src('assets/core/settings/js/admin.js')
    .pipe($.plumber())
    .pipe($.jspm({selfExecutingBundle: true}))
    .pipe($.rename('admin.bundle.js'))
    .pipe(gulp.dest('assets/core/settings/js'));
});

gulp.task('watch', function() {
  gulp.watch(['./resources/assets/**'], ['default']);
});

gulp.task('assets:csscomb', function() {
  return gulp.src('./resources/assets/**/*.scss')
    .pipe($.plumber())
    .pipe($.csscomb())
    .pipe(gulp.dest('./resources/assets/'));
});


gulp.task('csslint', function() {
  gulp.src('./resources/assets/core/**/*.css')
    .pipe($.plumber())
    .pipe($.csslint())
    .pipe($.csslint.reporter());
});


gulp.task('assets:sass', function () {
  return gulp.src('./resources/assets/**/*.scss')
    .pipe($.if(config.useSourceMaps, $.sourcemaps.init()))
    .pipe($.plumber())
    .pipe($.sass({outputStyle: 'expanded'}).on('error', $.sass.logError))
    .pipe($.if(config.useSourceMaps, $.sourcemaps.write(".")))
    .pipe(gulp.dest('./assets'));
});


/* lint */
var lint_ignore = ['**/bower_components/**', '**/*.min.*'];
gulp.task('lint', ['lint:sass', 'lint:css', 'lint:js']);

gulp.task('lint:sass', function () {
  return gulp.src('resources/assets/**/*.s+(a|c)ss')
    .pipe($.plumber())
    .pipe($.ignore.exclude(lint_ignore))
    .pipe($.sassLint())
    .pipe($.sassLint.format())
    .pipe($.sassLint.failOnError())
});

gulp.task('lint:css', function() {
  return gulp.src('./resources/assets/**/*.css')
    .pipe($.plumber())
    .pipe($.ignore.exclude(lint_ignore))
    .pipe($.csslint())
    .pipe($.csslint.reporter('compact'));
});

gulp.task('lint:js', function() {
  return gulp.src('resources/assets/**/*.js')
    .pipe($.plumber())
    .pipe($.ignore.exclude(lint_ignore))
    .pipe($.jshint())
    .pipe($.jshint.reporter())
    .pipe($.jshint.reporter('fail'));
});
/* END:lint */

gulp.task('jspm-assets', function() {
  var assets = [];

  // jQuery
  assets.push($.jspmAssets.jspmAssets({
      'jquery': '**/*',
      'jquery-migrate': 'dist/jquery-migrate.min.js'
    })
  // normalize
    .pipe(gulp.dest('./assets/vendor/jquery')));
  assets.push($.jspmAssets.jspmAssets('normalize.css', 'normalize.css')
    .pipe(gulp.dest('./assets/vendor/normalize')));
  // Swiper@^2
  assets.push($.jspmAssets.jspmAssets('swiper2', 'dist/*')
    .pipe(gulp.dest('./assets/vendor/swiper2')));
  // blueimp-file-upload
  // assets.push($.jspmAssets.jspmAssets('blueimp-file-upload', '**/*')
  //   .pipe(gulp.dest('./assets/vendor/blueimp-file-upload')));
  // lodash
  assets.push($.jspmAssets.jspmAssets('lodash', 'lodash.min.js')
    .pipe(gulp.dest('./assets/vendor/lodash')));
  // moment
  assets.push($.jspmAssets.jspmAssets('moment', 'moment.js')
    .pipe($.uglify())
    .pipe($.rename('moment.min.js'))
    .pipe(gulp.dest('./assets/vendor/moment')));
  assets.push($.jspmAssets.jspmAssets('moment', 'locale/*')
    .pipe($.uglify())
    .pipe(gulp.dest('./assets/vendor/moment/locale')));

  return merge(assets);
});
