import gulp from 'gulp'
import jsdoc from 'gulp-jsdoc3'
import webpack from 'webpack-stream'
import wpConfig from './webpack.config.babel.js'
import wpConfigDll, { resolveAlias } from './dll.webpack.config.babel.js'
const argv = require('minimist')(process.argv.slice(2))
const sass = require('gulp-sass')(require('sass'));
const $ = require('gulp-load-plugins')();

const mode = (process.env.NODE_ENV !== 'production') ? 'develoment' : 'production'
let generateSourceMaps = mode !== 'production'
const ignore = [
  '!node_modules/**/*',
  '!./**/xe-ui-component/slickgrid/**/*',
  '!core/settings/css/bootstrap/**/*',
  '!core/plugin/swiper2/idangerous.swiper.css'
]

if (process.env.SOURCEMAPS === 'true' || process.env.SOURCEMAPS === '1') {
  generateSourceMaps = true
}

function mergeWpConfig (config) {
  const result = config

  if (argv._.includes('build')) {
    argv.p = true
  }

  result.mode = (mode === 'production' || argv.p) ? 'production' : 'development'
  result.devtool = (result.mode === 'production') ? false : 'inline-source-map'

  return result
}

const taskWebpackBundle = function () {
  return gulp.src('./webpack.config.babel.js')
    .pipe($.plumber())
    .pipe(webpack({
      config: mergeWpConfig(wpConfig),
      resolve: {
        resolveAlias
      },
      stats: 'minimal'
    }))
    .pipe(gulp.dest('../..'))
}
taskWebpackBundle.displayName = 'webpack:bundle'
taskWebpackBundle.flags = {
  '-p': 'Production mode (uglify)'
}

const taskWebpackDll = function () {
  return gulp.src('./dll.webpack.config.babel.js')
    .pipe($.plumber())
    .pipe(webpack({
      config: mergeWpConfig(wpConfigDll),
      resolve: {
        resolveAlias
      },
      stats: 'minimal'
    }))
    .pipe(gulp.dest('../..'))
}
taskWebpackDll.displayName = 'webpack:dll'
taskWebpackDll.flags = {
  '-p': 'Production mode (uglify)'
}

const taskLintScript = function () {
  return gulp.src(['./core/**/*.js', ...ignore])
    .pipe($.plumber())
    .pipe($.eslint())
    .pipe($.eslint.format())
}
taskLintScript.displayName = 'lint:script'

const taskLintScriptFix = function () {
  return gulp.src(['./core/**/*.js', ...ignore])
    .pipe($.plumber())
    .pipe($.eslint({
      fix: true
    }))
    .pipe($.eslint.format())
    .pipe(gulp.dest('./core'))
}
taskLintScriptFix.displayName = 'lint:fix-script'

const taskLintStyle = function () {
  return gulp.src(['./core/**/*.css', './core/**/*.scss', ...ignore])
    .pipe($.plumber())
    .pipe($.stylelint({
      reporters: [
        { formatter: 'string', console: true }
      ]
    }))
}
taskLintStyle.displayName = 'lint:style'

const taskFixStyle = function () {
  return gulp.src(['./core/**/*.css', './core/**/*.scss', ...ignore])
    .pipe($.plumber())
    .pipe($.stylelint({
      fix: true,
      reporters: [
        { formatter: 'string', console: true }
      ]
    }))
    .pipe(gulp.dest('./core'))
}
taskFixStyle.displayName = 'lint:fix-style'
taskFixStyle.description = '.scss 자동 교정'

const taskSass = function () {
  return gulp.src(['./core/**/*.scss', ...ignore])
    .pipe($.if(generateSourceMaps, $.sourcemaps.init()))
    .pipe(sass({ outputStyle: 'compressed', includePaths: ['node_modules'] }).on('error', sass.logError))
    .pipe($.autoprefixer({
      cascade: false
    }))
    .pipe($.if(generateSourceMaps, $.sourcemaps.write('.')))
    .pipe(gulp.dest('../../assets/core'))
}
taskSass.displayName = 'sass'

const taskHtmlBuildPreview = function () {
  const options = {
    root: '../markup'
  }
  const plugins = [
    require('posthtml-extend')(options),
    require('posthtml-include')(options)
  ]

  return gulp.src(['../markup/**/src/!(_)*.html'])
    .pipe($.plumber())
    .pipe($.posthtml(plugins))
    .pipe($.rename((path) => {
      let dirname = path.dirname.split('/')
      dirname.pop()
      path.dirname = dirname.join('/')
    }))
    .pipe(gulp.dest('../markup'))
}
taskHtmlBuildPreview.displayName = 'html:preview'
taskHtmlBuildPreview.description = 'PostHTML: 미리보기 생성'

const taskHtmlBuildSync = function () {
  const options = {
    root: './resources/markup'
  }
  const plugins = [ require('posthtml-include')(options) ]

  return gulp.src('resources/markup/src/views/**/*.html')
    // .pipe($.plumber())
    .pipe($.posthtml(plugins))
    .pipe($.rename({ extname: '.html' }))
    .pipe(gulp.dest('resources/sync-views'))
}
taskHtmlBuildSync.displayName = 'html:sync'

const taskClear = function () {
  return gulp.src('./jsdoc')
    .pipe($.clean({ force: true }))
}
taskClear.displayName = 'clear'

const taskJsdoc = function () {
  return gulp.src(['core/**/*.js', ...ignore])
    .pipe(jsdoc({
      'opts': {
        'destination': './jsdoc',
        'template': 'node_modules/docdash',
        'allowEmpty': true
      }
    }))
}
taskJsdoc.displayName = 'jsdoc'

const taskWatch = function () {
  gulp.watch(['./core/**/*.scss', ...ignore], taskSass)
  gulp.watch(['./core/**/*.js', './core/**/*.vue', ...ignore], gulp.series(taskWebpackDll, taskWebpackBundle))
}

const taskBuild = gulp.series(taskWebpackDll, taskWebpackBundle, taskSass)
taskBuild.displayName = 'build'

const taskWebpack = gulp.series(taskWebpackDll, taskWebpackBundle)
taskWebpack.displayName = 'webpack'
taskWebpack.flags = {
  '-p': 'Production mode (uglify)'
}

gulp.task(taskBuild)
gulp.task(taskSass)
gulp.task(taskLintStyle)
gulp.task(taskFixStyle)
gulp.task(taskLintScript)
gulp.task(taskLintScriptFix)

// PostHTML
gulp.task(taskHtmlBuildPreview)

// webpack
gulp.task(taskWebpack)
gulp.task(taskWebpackBundle)
gulp.task(taskWebpackDll)

gulp.task('watch', taskWatch)

gulp.task('jsdoc', gulp.series(taskClear, taskJsdoc))
