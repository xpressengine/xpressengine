(function(exports) {
    exports.DynamicLoadManager = function() {
        var _assets = {
            js: {}
            , css: {}
        };

        return {
            jsLoad: function(url, load, error) {
                var src = url.split('?')[0];

                if(!_assets.js.hasOwnProperty(src)) {
                    var el = document.createElement( 'script' );
                    el.src = url;

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
                    var $css = $('<link>', {rel: 'stylesheet', type: 'text/css', href: url}).on('load', load).on('error', error);

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