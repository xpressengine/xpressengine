var gulp = require("gulp"),
  $ = require('gulp-load-plugins')();
var runSequence = require('run-sequence');
var elixir = require('laravel-elixir');
var _ = require('lodash');

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

// assets 재구성을 위한 임시 task
elixir(function(mix) {
  mix.copy('resources/assets/core', 'assets/core');
});


gulp.task('default', function(callback){
  runSequence(
    'copy-assets',
    'assets:sass',
    'jspm:admin',
    'jspm:component',
    'jspm:menu',
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
    'jspm:admin',
    'jspm:component',
    'jspm:menu',
    callback);
});

gulp.task('jspm:xe', function(){
  return gulp.src('assets/core/common/js/xe.js')
    .pipe($.plumber())
    .pipe($.jspm({inject: true, selfExecutingBundle: true}))
    .pipe($.rename('xe.bundle.js'))
    .pipe(gulp.dest('assets/core/common/js'));
});

gulp.task('jspm:menu', function(){
  return gulp.src('assets/core/menu/MenuTree.js')
    .pipe($.plumber())
    .pipe($.jspm({selfExecutingBundle: true, plugin: 'jsx'}))
    .pipe($.rename('menu.js'))
    .pipe(gulp.dest('assets/core/menu'));
});

gulp.task('jspm:component', function(){
  return gulp.src('assets/core/settings/js/admin.js')
    .pipe($.plumber())
    .pipe($.jspm({selfExecutingBundle: true}))
    .pipe($.rename('admin.bundle.js'))
    .pipe(gulp.dest('assets/core/settings/js'));
});

gulp.task('jspm:admin', function(){
  return gulp.src('assets/core/xe-ui-component/js/xe-ui-component.js')
    .pipe($.plumber())
    .pipe($.jspm())
    .pipe($.rename('xe-ui-component.bundle.js'))
    .pipe(gulp.dest('assets/core/xe-ui-component/js'));
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
    .pipe($.plumber())
    .pipe($.sass({outputStyle: 'expanded'}).on('error', $.sass.logError))
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

