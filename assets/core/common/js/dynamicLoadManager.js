(function(exports) {
    'use strict';

    exports.DynamicLoadManager = function() {
        var _assets = {
            js: {}
            , css: {}
        };

        return {
            jsLoadMultiple: function(arrjs) {
                var html = "";

                for(var i = 0, max = arrjs.length; i < max; i += 1) {
                    html += "<script src='" + arrjs[i] + "'></script>";
                }

                $("head").append(html);
            },
            jsLoad: function(url, load, error) {

                var src = url.split('?')[0];

                if(!_assets.js.hasOwnProperty(src)) {
                    var el = document.createElement( 'script' );
                    el.src = url;
                    el.async = true;

                    if(load) {
                        el.onload = load;
                    }

                    if(error) {
                        el.onerror = error;
                    }

                    document.head.appendChild(el);

                    _assets.js[src] = "";

                }else {
                    if(load) {
                        load();
                    }
                }
            },
            cssLoad: function(url, load, error) {
                var src = url.split("?")[0];

                if(!_assets.css.hasOwnProperty(src)) {
                    var $css = $('<link>', {rel: 'stylesheet', type: 'text/css', href: url});

                    if(load) {
                        $css.on('load', load)
                    }

                    if(error) {
                        $css.on('error', error)
                    }

                    $('head').append($css);

                    _assets.css[src] = "";
                }else {
                    if(load) {
                        load();
                    }
                }
            }
        };
    }();
})(window);