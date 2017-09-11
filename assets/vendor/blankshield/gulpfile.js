var gulp   = require('gulp');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var header = require('gulp-header');

var pkg    = require('./package.json');
var banner = [
  '/**',
  ' * <%= pkg.name %> - <%= pkg.description %>',
  ' *',
  ' * @version   <%= pkg.version %>',
  ' * @link      <%= pkg.homepage %>',
  ' * @author    <%= pkg.author %>',
  ' * @license   <%= pkg.license %>',
  ' */\n'
].join('\n');

var paths = {
  scripts: './blankshield.js',
  dist: './'
};

gulp.task('minify', function() {
  gulp.src(paths.scripts)
    .pipe(uglify())
    .pipe(header(banner, {pkg: pkg}))
    .pipe(rename(function(path) {
      path.basename += '.min';
    }))
    .pipe(gulp.dest(paths.dist));
});

gulp.task('dist', ['minify']);
