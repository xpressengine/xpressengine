(function(exports) {

    'use strict';

    exports.DynamicLoadManager = function() {

        var self;
        var _assets = {
            js: {}
            , css: {}
        };

        var _loadUtils = function(cb) {
            var loc = exports.location;
            var url = "assets/core/common/js/utils.js";
            var baseURL = loc.protocol + '//' + loc.host + '/';

            if(!_assets.js.hasOwnProperty(baseURL + url)) {
                var el = document.createElement( 'script' );
                el.src = baseURL + url;
                el.async = true;
                el.onload = cb;

                document.head.appendChild(el);

                _assets.js[baseURL + url] = '';
            }
        };

        return {
            init: function() {
                self = this;

                return this;
            },
            /**
             * @param {array} arrjs
             * @param {object}} callbackObj
             * <pre>
             *     - load
             *     - error
             *     - complete
             * </pre>
             * */
            jsLoadMultiple: function (arrjs, callbackObj) {
                var count = 0;
                var callbackObj = callbackObj || {};

                _loadUtils(function() {
                    for(var i = 0, max = arrjs.length; i < max; i += 1) {
                        var src = Utils.asset(arrjs[i]);

                        if(!_assets.js.hasOwnProperty(src)) {
                            _assets.js[src] = '';

                            $.ajax({
                                url: src,
                                async: false,
                                dataType: "script",
                                success: function() {
                                    count++;

                                    if(!!callbackObj.load) {
                                        callbackObj.load();
                                    }

                                    if(count === arrjs.length && !!callbackObj.complete) {
                                        callbackObj.complete();
                                    }
                                },
                                error: callbackObj.error
                            });

                        }else {
                            if(!!callbackObj.load) {
                                callbackObj.load();
                            }
                        }
                    }
                });

            },
            jsLoad: function (url, load, error) {
                _loadUtils(function() {
                    var src = Utils.asset(url);

                    if(!_assets.js.hasOwnProperty(src)) {

                        var el = document.createElement( 'script' );

                        el.src = src;
                        el.async = true;

                        if(load) {
                            el.onload = load;
                        }

                        if(error) {
                            el.onerror = error;
                        }

                        document.head.appendChild(el);

                        _assets.js[src] = '';


                    }else {
                        if(load) {
                            load();
                        }
                    }
                });
            },
            cssLoad: function (url, load, error) {
                _loadUtils(function() {
                    var src = Utils.asset(url);

                    if(!_assets.css.hasOwnProperty(src)) {

                        var $css = $('<link>', {rel: 'stylesheet', type: 'text/css', href: src});

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
                });
            }
        };
    }().init();

})(window);

//# sourceURL=dynamicLoadManager.js