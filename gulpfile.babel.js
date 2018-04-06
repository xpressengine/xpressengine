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
  return gulp.src('./resources/assets/core/**/*.scss')
    .pipe(gulpSass({
      outputStyle: 'compressed'
    }))
    .pipe(gulp.dest('./assets/core'))
})

gulp.task('jsdoc', () => {
  var merged = stream(
    gulp.src('./resources/jsdoc')
      .pipe($.clean({ force: true })),
    gulp.src([
      './resources/assets/core/**/*.js',
      '!./resources/assets/core/xe-ui-component/slickgrid/*'
    ])
      .pipe(jsdoc({
        'opts': {
          'destination': './resources/jsdoc',
          'template': 'node_modules/docdash'
        }
      }))
  )
  return merged
})
