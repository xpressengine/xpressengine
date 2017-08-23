import gulp from 'gulp';
import plugins from 'gulp-load-plugins';
import jsdoc from 'gulp-jsdoc3';
import stream from 'merge-stream';

module.exports = (() => {

  'use strict';

  const $ = plugins();

  let _config = {
    isProduction: !!$.util.env.production, useSourceMaps: false,
  };

  const _filter = [
   '**/*',
   '!**/*.scss',
   '!resources/assets/core/lang/LangEditorBox.js',
   '!resources/assets/core/permission/*.jsx',
   '!resources/assets/core/permission/*.js',
   '!resources/assets/core/settings/js/admin.js',
   '!resources/assets/core/xe-ui-component/components',
   '!resources/assets/core/**/img/*',
   '!resources/assets/core/common/js/storeCategory.js',
   '!resources/assets/core/common/js/dynamicField.js',
   '!resources/assets/core/common/js/xe.js',
   '!resources/assets/core/common/js/toggleMenu.js',
   '!resources/assets/core/member/settings/edit.js',
   '!resources/assets/core/tree/**.js',
   'resources/assets/core/xe-ui-component/js/*',
   'resources/assets/core/category/Category.js',
   'resources/assets/core/menu/Menu.js',
   'resources/assets/core/menu/SearchHead.js',
   'resources/assets/core/menu/SiteMap.js',
   'resources/assets/core/widgetbox/js/*',
  ];

  let self = {
    /**
     * assets 삭제
     * */
    'clean:assets': () => {
      return gulp.src('./assets/core')
        .pipe($.clean({ force: true }));

    },
    /**
     * ./resources/assets 에서 필요한 파일만 복사
     * */
    'copy:assets': () => {

      let filters = self.getDefaultFilter();

      if (_config.isProduction) {
        _filter.push('!**/*.map');
      }

      return gulp.src('resources/assets/core/**/*', { base: './resources/assets/core' })
        .pipe($.plumber())
        .pipe($.filter(filters))
        .pipe(gulp.dest('assets/core'));

    },

    'assets:chunk': () => {
      return gulp.src([
         'assets/core/common/js/utils.js',
         'assets/core/common/js/dynamicLoadManager.js',
         'assets/core/common/js/translator.js',
         'assets/vendor/jquery/jquery.min.js',
        ])
        .pipe($.plumber())
        .pipe($.uglify())
        .pipe($.concat('bundle.js'))
        .pipe(gulp.dest('assets'));
    },

    'assets:tree': () => {
      return gulp.src([
          'assets/vendor/jqueryui/jquery-ui.sortable.js',
          'assets/vendor/nestedSortable/jquery.mjs.nestedSortable.js',
          'resources/assets/core/tree/Item.js',
          'resources/assets/core/tree/Tree.js',
        ])
        .pipe($.plumber())
        .pipe($.uglify())
        .pipe($.concat('xe.tree.js'))
        .pipe(gulp.dest('assets/core/common/js'));
    },

    jscs: () => {
      return gulp.src('./resources/assets/core/**/*')
        .pipe($.jscs({
        configPath: './.jscsrc',
      }))
        .pipe($.jscs.reporter())
        .pipe(gulp.dest('./resources/assets/core'));
    },

    getDefaultFilter: () => {
      return Object.assign([], _filter);
    },

    getConfig: () => {
      return _config;
    },

    'doc:core': () => {
      var merged = stream(
        gulp.src('./resources/doc')
        .pipe($.clean({ force: true }))
        ,
        gulp.src(['./resources/assets/core/**/*.js', './resources/assets/core/**/*.jsx'])
        .pipe(jsdoc({
          "opts": {
            "destination": "./resources/doc"
          }
        }))
      );

      return merged;
    },
  };

  return self;
})();
