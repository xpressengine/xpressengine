var gulp = require("gulp"),
    concat = require("gulp-concat"),
    clean = require("gulp-clean"),
    $ = require('gulp-load-plugins')(),
    sourcemaps = require('gulp-sourcemaps');
var runSequence = require('run-sequence');
var elixir = require('laravel-elixir');
var merge = require('merge-stream');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
  mix.browserify('../core/menu/MenuTree.jsx', 'assets/vendor/menu/menu.js');
});

gulp.task('clean', function () {
  return gulp.src('assets/core/common/js/xe.bundle.js')
    .pipe(clean({force: true}));
});

// assets 재구성을 위한 임시 task
elixir(function(mix) {
  mix.copy('resources/assets/core', 'assets/core');
});

gulp.task('default', function(callback){
  runSequence(
    'clean',
    'copy-assets',
    'assets:sass',
    'jspm:component',
    'jspm:menu',
    'jspm:langbox',
    'jspm:xe',
    callback);
});

gulp.task('copy-assets', function () {
  var ignore = $.filter(['**/*', '!**/*.scss']);

  return gulp.src('./resources/assets/core/**')
    .pipe($.plumber())
    .pipe(ignore)
    .pipe(gulp.dest('./assets/core'));
});

gulp.task('jspm', ['copy-assets'], function(callback){
  runSequence(
    'jspm:component',
    'jspm:menu',
    'jspm:langbox',
    callback);
});

gulp.task('jspm:xe', function() {
  return gulp.src(['assets/core/common/js/xe.js', 'assets/core/common/js/translator.js', 'assets/core/common/js/xe.lang.js', 'assets/core/common/js/xe.progress.js', 'assets/core/common/js/xe.request.js', 'assets/core/common/js/xe.component.js'])
    .pipe(concat('xe.bundle.js'))
    .pipe(gulp.dest('assets/core/common/js/'));
});

gulp.task('jspm:menu', function(){
  return gulp.src('assets/core/menu/MenuTree.js')
    .pipe($.plumber())
    .pipe($.jspm({selfExecutingBundle: true, plugin: 'jsx'}))
    .pipe($.rename('menu.js'))
    .pipe(gulp.dest('assets/core/menu'));
});

gulp.task('jspm:langbox', function(){
  return gulp.src('assets/core/lang/LangEditorBox.js')
    .pipe($.plumber())
    .pipe($.jspm({selfExecutingBundle: true, plugin: 'jsx'}))
    .pipe($.rename('LangEditorBox.bundle.js'))
    .pipe(gulp.dest('assets/core/lang'));
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
    .pipe(sourcemaps.init())
    .pipe($.plumber())
    .pipe($.sass({outputStyle: 'expanded'}).on('error', $.sass.logError))
    .pipe(sourcemaps.write("."))
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
