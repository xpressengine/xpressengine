import gulp from 'gulp'
import plugins from 'gulp-load-plugins'
import runSequence from 'run-sequence'
import events from 'events'
import stream from 'merge-stream'
import jsdoc from 'gulp-jsdoc3'

events.EventEmitter.defaultMaxListeners = Infinity

const $ = plugins()

gulp.task('default', (callback) => {})

gulp.task('jsdoc', () => {
  var merged = stream(
    gulp.src('./resources/jsdoc')
      .pipe($.clean({ force: true })),
    gulp.src(['./resources/assets/core/**/*.js'])
      .pipe(jsdoc({'opts': {'destination': './resources/jsdoc'}}))
  )
  return merged
})
