var gulp = require("gulp"),
  $ = require('gulp-load-plugins')();
var elixir = require('laravel-elixir');
var _ = require('lodash');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
  mix.browserify('../core/menu/MenuTree.jsx', 'assets/vendor/menu/menu.js');
});

// assets 재구성을 위한 임시 task
elixir(function(mix) {
  mix.copy('resources/assets/core', 'assets/core');
});
