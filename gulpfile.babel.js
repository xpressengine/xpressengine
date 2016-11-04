
'use strict';

import gulp from 'gulp';
import plugins from 'gulp-load-plugins';
import runSequence from 'run-sequence';

import taskSettings from './resources/gulpTasks/settings';
import taskCss from './resources/gulpTasks/css';
import taskImage from './resources/gulpTasks/image';

const $ = plugins();

gulp.task('default', (callback) => {
  runSequence(
      'clean:assets',
      'copy:assets',
      'jspm:admin',
      'jspm:xe',
      'assets:sass',
      'assets:image',
      callback);
});

// s: settings
gulp.task('clean:assets', taskSettings['clean:assets']);
gulp.task('copy:assets', taskSettings['copy:assets']);

gulp.task('jspm:xe', taskSettings['jspm:xe']);
gulp.task('jspm:admin', taskSettings['jspm:admin']);
// e: settings

// s: css
gulp.task('assets:sass', taskCss['assets:sass']);
// e: css

// s: image
gulp.task('assets:image', taskImage['assets:image']);
// e: image