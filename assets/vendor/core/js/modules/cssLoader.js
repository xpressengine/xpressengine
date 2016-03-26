define(['require'], function (require) {
    'use strict';

    var CssLoader = {};

    CssLoader.get = function(url) {
        var css = document.createElement('link');
        css.rel = 'stylesheet';
        css.href = url;

        document.head.appendChild(css);
    };

    return CssLoader;
});