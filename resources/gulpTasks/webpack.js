import gulp from 'gulp';
import plugins from 'gulp-load-plugins';


module.exports = (() => {

    'use strict';

    const $ = plugins();

    return {
        /**
         * menu jsx변환 및 bundle, 일부 파일 copy
         * */
        'webpack:react': () => {
            return $.webpack(require('../../webpack.config.js'));
        }
    };
})();