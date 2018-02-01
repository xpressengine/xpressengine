import gulp from 'gulp'
import plugins from 'gulp-load-plugins'
import jsdoc from 'gulp-jsdoc3'
import stream from 'merge-stream'

module.exports = (() => {
  'use strict'

  const $ = plugins()

  let _config = {
    isProduction: !!$.util.env.production, useSourceMaps: false
  }

  let self = {
    jscs: () => {
      return gulp.src('./resources/assets/core/**/*')
        .pipe($.jscs({
          configPath: './.jscsrc'
        }))
        .pipe($.jscs.reporter())
        .pipe(gulp.dest('./resources/assets/core'))
    },

    getConfig: () => {
      return _config
    },

    'jsdoc': () => {
      var merged = stream(
        gulp.src('./resources/jsdoc')
        .pipe($.clean({ force: true }))
        ,
        gulp.src(['./resources/assets/core/**/*.js', './resources/assets/core/**/*.jsx'])
        .pipe(jsdoc({
          'opts': {
            'destination': './resources/jsdoc'
          }
        }))
      )

      return merged
    }
  }

  return self
})()
