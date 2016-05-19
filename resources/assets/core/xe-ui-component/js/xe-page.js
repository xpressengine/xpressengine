var page = (function($) {
    var self = this;
    var _assets = {};

    var pageCommon = function() {
        return {
            init: function () {
                self = this;
                self.bindEvent();

                return this;
            },
            bindEvent: function () {
                $(document).on('click', 'a[data-modal=xe-page]', self.openXeModal);
            },
            openXeModal: function (e) {
                e.preventDefault();

                var $this = $(this),
                    targetSelector = $this.data('target'),
                    callback = $this.data('callback');

                var objStack = callback.split(".");
                var callbackFunc = window;

                if(objStack.length > 0) {
                    for(var i = 0, max = objStack.length; i < max; i += 1) {
                        callbackFunc = callbackFunc[objStack[i]];
                    }
                }
            },
            loadDone: function(cssLen, jsLen, callback) {
                var loadingCount = 0;

                return function(e) {
                    loadingCount++;

                    var src = (e.target.tagName === 'LINK')? e.target.href.split("?")[0] : e.target.src.split('?')[0];
                    _assets[src] = {};


                    if(cssLen + jsLen === loadingCount && !!callback) {
                        callback();
                    }
                }
            }
        };
    };
    //}().init();

    return {
        /**
         * @param {object} options
         * <pre>
         *     - selector   : {string} css selector
         *     - url        : {stirng} html file path
         *     - type       : {string} default 'post'
         * </pre>
         * @param {function} callback
         * @description
         * <pre>
         *     selecor영역에 html을 로드하여 보여준다. html 랜더링 전에 assets파일들의 로드가 선행된다.
         * </pre>
         * */
        page: function(options, callback) {
            var $target = $(options.selector);

            if(!options.hasOwnProperty('type') || ['get', 'post'].indexOf(options.type.toLowerCase()) === -1) {
                console.error('type [ get | post ]');
                return;
            }

            // var css = [],//['https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/themes/blitzer/jquery-ui.min.css'],
            //     js = ['https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js'],
            //     html = "<div id='test'></div>";
            //
            // var loadDone = pageCommon.loadDone(css.length, js.length, function() {
            //     $target.html(html);
            //
            //     if(callback) {
            //         callback();
            //     }
            // });
            //
            // if(css.length > 0) {
            //     for(var i = 0, max = css.length; i < max; i += 1) {
            //         if(!_assets.hasOwnProperty(css[i])) {
            //             XE.cssLoad(css[i], loadDone, loadDone);
            //         }
            //     }
            // }
            //
            // if(js.length > 0) {
            //     for (var i = 0, max = js.length; i < max; i += 1) {
            //         if (!_assets.hasOwnProperty(js[i])) {
            //             XE.jsLoad(js[i], loadDone, loadDone);
            //         }
            //     }
            // }
            //<script type="text/javascript" src="/assets/core/xe-ui-component/js/xe-page.js"></script>

            XE.Request[options.type](options.url, {}, function(data) {
                var assets = data['XE_ASSET_LOAD'],
                    css = assets['css'] || [],
                    js = assets['js'] || [],
                    html = data.html;

                var loadDone = pageCommon.loadDone(css.length, js.length, function() {
                    $target.html(html);

                    if(callback) {
                        callback();
                    }
                });

                if(css.length > 0) {
                    for(var i = 0, max = css.length; i < max; i += 1) {
                        if(!_assets.hasOwnProperty(css[i])) {
                            XE.cssLoad(css[i]);
                            loadDone();
                        }
                    }
                }

                if(js.length > 0) {
                    for(var i = 0, max = js.length; i < max; i += 1) {
                        if(!_assets.hasOwnProperty(js[i])) {
                            XE.jsLoad(js[i]);
                            loadDone();
                        }
                    }
                }


            }, 'json');

        },
        /**
         * @param {object} options
         * <pre>
         *     - url        : {string} html file path
         *     - type       : {string} default 'post'
         * </pre>
         * @param {function} callback
         * */
        modalPage: function(options, callback) {


        }
    };
})(jQuery);