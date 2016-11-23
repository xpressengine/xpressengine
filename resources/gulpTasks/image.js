import gulp from 'gulp';
import plugins from 'gulp-load-plugins';

module.exports = (() => {

  'use strict';

  const $ = plugins();

  return {
    /**
     * 이미지 파일 최적화
     * */
    'assets:image': () => {
      return gulp.src([
          './resources/assets/core/**/*.png',
          './resources/assets/core/**/*.jpg',
          './resources/assets/core/**/*.jpeg',
          './resources/assets/core/**/*.gif',
        ], { base: './resources/assets/core' })
        .pipe($.imagemin())
        .pipe(gulp.dest('assets/core'));
    },
  };
})();
