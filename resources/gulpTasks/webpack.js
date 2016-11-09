import plugins from 'gulp-load-plugins';

module.exports = (() => {
    'use strict';

    const $ = plugins();

    return {
        'webpack:react': () => {
            return $.webpack(require('../../webpack.config.js'));
        }
    };
})();