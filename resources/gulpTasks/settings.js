import gulp from 'gulp';
import plugins from 'gulp-load-plugins';

module.exports = (() => {

    'use strict';

    const $ = plugins();
    
    let _config = {
        isProduction: !!$.util.env.production
        , useSourceMaps: false//!$.util.env.production
    };

    return {
        'clean:assets': () => {
            gulp.task('clean:assets', () => {
                return gulp.src('resources/assets/core/menu/MenuTree.js')
                    .pipe($.plumber())
                    .pipe($.jspm({selfExecutingBundle: true, plugin: 'jsx'}))
                    .pipe($.rename('menu.js'))
                    .pipe(gulp.dest('assets/core/menu'));
            });

        },
        'copy:assets': () => {
            gulp.tast('copy:assets', () => {
                var ignore = $.filter(['**/*', '!**/*.scss']);
                var assets = [
                    
                ];

                return gulp.src('./resources/assets/core/**')
                    .pipe($.if(settings.getConfig().useSourceMaps, $.sourcemaps.init()))
                    .pipe($.plumber())
                    .pipe(ignore)
                    .pipe(gulp.dest('./assets/core'));
            });

        },
        getConfig: () => {
            return _config;
        }
    };
})();