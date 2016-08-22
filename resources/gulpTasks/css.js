import gulp from 'gulp';
import plugins from 'gulp-load-plugins';
import taskSettings from './settings';

module.exports = (() => {

    'use strict';

    const $ = plugins();

    return {
        /**
         * menu jsx변환 및 bundle, 일부 파일 copy
         * */
        'assets:sass': () => {
            return gulp.src('./resources/assets/**/*.scss')
                .pipe($.if(taskSettings.getConfig().useSourceMaps, $.sourcemaps.init()))
                .pipe($.plumber())
                .pipe($.sass({outputStyle: 'expanded'}).on('error', $.sass.logError))
                .pipe($.if(taskSettings.getConfig().useSourceMaps, $.sourcemaps.write(".")))
                .pipe(gulp.dest('./assets'));
        }
    };
})();