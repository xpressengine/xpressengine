import gulp from 'gulp'
import plugins from 'gulp-load-plugins'
import runSequence from 'run-sequence'
import events from 'events'
import stream from 'merge-stream'
import jsdoc from 'gulp-jsdoc3'
import gulpSass from 'gulp-sass'

events.EventEmitter.defaultMaxListeners = Infinity

const $ = plugins()

gulp.task('default', (callback) => {})

gulp.task('assets', ['assets-sass'])

gulp.task('assets-sass', () => {
  return gulp.src(['./core/**/*.scss', '!node_modules/**/*'])
    .pipe(gulpSass({
      outputStyle: 'compressed'
    }))
    .pipe(gulp.dest('../../assets/core'))
})

gulp.task('jsdoc', () => {
  var merged = stream(
    gulp.src('./jsdoc')
      .pipe($.clean({ force: true })),
    gulp.src([
      'core/**/*.js',
      '!xe-ui-component/slickgrid/*',
      '!node_modules/**/*'
    ])
      .pipe(jsdoc({
        'opts': {
          'destination': './jsdoc',
          'template': 'node_modules/docdash'
        }
      }))
  )
  return merged
})
