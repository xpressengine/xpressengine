import plugins from 'gulp-load-plugins';
import webpack from 'webpack';
import webpackConfig from '../../webpack.config.js';

module.exports = (() => {
  'use strict';

  const $ = plugins();

  return {
    'webpack': (callback) => {
      webpack(webpackConfig, (err, stats) => {
        if (err) {
          throw new gutil.PluginError('webpack', err);
        }

        callback();
      });
    },
  };
})();
