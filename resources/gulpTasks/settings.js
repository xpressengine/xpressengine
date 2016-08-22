import gulp from 'gulp';
import plugins from 'gulp-load-plugins';

module.exports = (() => {

    'use strict';

    const $ = plugins();
    
    let _config = {
        isProduction: !!$.util.env.production
        , useSourceMaps: false//!$.util.env.production
    };

    let _filter = [
        '**/*',
        '!resources/assets/core/menu/*',
        '!**/*.scss',
        '!resources/assets/core/lang/LangEditorBox.js',
        '!resources/assets/core/permission/*.jsx',
        '!resources/assets/core/permission/*.js',
        '!resources/assets/core/settings/js/admin.js',
        '!resources/assets/core/xe-ui-component/components',
        '!resources/assets/core/**/img/*',
        'resources/assets/core/xe-ui-component/js/*',
        'resources/assets/core/menu/classnames.js',
        'resources/assets/core/menu/Tree.js'
    ];

    let self = {
        /**
         * assets 삭제
         * */
        'clean:assets': () => {
            return gulp.src('./assets/core')
                .pipe($.clean({force: true}));

        },
        /**
         * ./resources/assets 에서 필요한 파일만 복사
         * */
        'copy:assets': () => {

            let filters = self.getDefaultFilter();

            if(_config.isProduction) {
                filter.push('!**/*.map');
            }

            return gulp.src('resources/assets/core/**/*', {base: "./resources/assets/core"})
                .pipe($.plumber())
                .pipe($.filter(filters))
                .pipe(gulp.dest('assets/core'));

        },
        /**
         * xe bundling
         * */
        'jspm:xe': () => {
            return gulp.src([
                    './assets/core/common/js/xe.js',
                    './assets/core/common/js/translator.js',
                    './assets/core/common/js/xe.lang.js',
                    './assets/core/common/js/xe.progress.js',
                    './assets/core/common/js/xe.request.js',
                    './assets/core/common/js/xe.component.js'
                ])
                .pipe($.concat('xe.bundle.js'))
                .pipe(gulp.dest('./assets/core/common/js/'));
        },
        /**
         * admin bundling
         * */
        'jspm:admin': () => {
            return gulp.src('./resources/assets/core/settings/js/admin.js')
                .pipe($.plumber())
                .pipe($.jspm({selfExecutingBundle: true}))
                .pipe($.rename('admin.bundle.js'))
                .pipe(gulp.dest('./assets/core/settings/js'));
        },
        getDefaultFilter: () => {
            return Object.assign([], _filter);
        },
        getConfig: () => {
            return _config;
        }
    };

    return self
})();