var gulp = require("gulp");
var elixir = require('laravel-elixir');
var react = require('gulp-react');
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

    mix.browserify('menu/MenuTree.jsx', 'assets/vendor/menu/menu.js');
});
