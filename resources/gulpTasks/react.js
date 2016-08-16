import gulp from 'gulp';
import plugins from 'gulp-load-plugins';
import react from 'gulp-react';
import runSequence from 'run-sequence';
import taskSettings from './settings';

module.exports = (() => {

    'use strict';

    const $ = plugins();

    //menu jsx변환 및 bundle
    gulp.task('jspm:menu.bundle', () => {
        return gulp.src('resources/assets/core/menu/MenuTree.js')
            .pipe($.plumber())
            .pipe($.jspm({selfExecutingBundle: true, plugin: 'jsx'}))
            .pipe($.rename('menu.js'))
            .pipe(gulp.dest('assets/core/menu'));
    });

    //menu-copy
    gulp.task('jspm:menu.copy', () => {
        return gulp.src([
                'resources/assets/core/menu/Tree.js',
                'resources/assets/core/menu/classnames.js'
            ]).pipe(gulp.dest('assets/core/menu'));
    });
    
    return {
        /**
         * menu jsx변환 및 bundle, 일부 파일 copy
         * */
        'jspm:menu': (callback) => {
            runSequence(
                'jspm:menu.bundle',
                'jspm:menu.copy',
                callback
            );
        },
        /**
         * langbox jsx변환 및 bundle
         * */
        'jspm:langbox': () => {
            return gulp.src('resources/assets/core/lang/LangEditorBox.js')
                .pipe($.plumber())
                .pipe($.jspm({selfExecutingBundle: true, plugin: 'jsx'}))
                .pipe($.rename('LangEditorBox.bundle.js'))
                .pipe(gulp.dest('./assets/core/lang'))

        },
        /**
         * permission jsx변환
         * */
        'jsx:permission': () => {
            return gulp.src('resources/assets/core/permission/*.jsx')
                .pipe($.if(taskSettings.getConfig().useSourceMaps, $.sourcemaps.init()))
                .pipe($.plumber())
                .pipe(react())
                .pipe($.if(taskSettings.getConfig().useSourceMaps, $.sourcemaps.write('.')))
                .pipe(gulp.dest('./assets/core/permission'))
        }
    };
})();