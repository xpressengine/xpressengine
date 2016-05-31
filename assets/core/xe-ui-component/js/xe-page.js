(function($, exports, XE) {
    var self = this;
    var _assets = {
        src: {}
    };

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
                    callback = $this.data('callback'),
                    url = $this.attr('url');

                var objStack = callback.split(".");
                var callbackFunc = window;

                var options = {
                    url: url,
                    target: targetSelector
                };

                if(objStack.length > 0) {
                    if(self.isValidPageModal()) {
                        for(var i = 0, max = objStack.length; i < max; i += 1) {
                            callbackFunc = callbackFunc[objStack[i]];
                        }
                    }

                }

                XE.pageModal({

                });
            },
            cssLoad: function(url, load, error) {
                var $css = $('<link>', {rel: 'stylesheet', type: 'text/css', href: url}).on('load', load).on('error', error);

                $('head').append($css);
            },
            jsLoad: function(url, load, error) {
                var el = document.createElement( 'script' );
                el.src = url;

                if(load) {
                    el.onload = load;
                }

                if(error) {
                    el.onerror = error;
                }

                document.head.appendChild(el);
            },
            loadDone: function(cssLen, jsLen, next) {
                var loadingCount = 0;

                return function(e) {

                    loadingCount++;
                    //var src = (e.target.tagName === 'LINK')? e.target.href.split("?")[0] : e.target.src.split('?')[0];

                    if((cssLen + jsLen) === loadingCount && !!next) {
                        next();
                    }
                }
            },
            isValidPage: function(options) {
                var isValid = true;

                if(!options.hasOwnProperty('type') || ['get', 'post'].indexOf(options.type.toLowerCase()) === -1) {
                    console.error('type [ get | post ]');
                    isValid = false;
                }

                return isValid;
            },
            isValidPageModal: function() {

            }
        }.init();
    }();

    /**
     * @param {object} options
     * <pre>
     *     - target   : {string} css selector
     *     - url        : {stirng} html file path
     *     - type       : {string} default 'post'
     * </pre>
     * @param {function} callback
     * @description
     * <pre>
     *     selecor영역에 html을 로드하여 보여준다. html 랜더링 전에 assets파일들의 로드가 선행된다.
     *
     *     동작 순서
     *     1)css로드
     *     2)html string append
     *     3)js로드
     *     4)callback 실행
     * </pre>
     * */
    XE.page = function(options, callback) {

        var $target = $(options.target);

        if(pageCommon.isValidPage(options)) {
            XE.Request[options.type](options.url, {}, function(data) {

                var assets = data['XE_ASSET_LOAD'],
                    css = assets['css'] || [],
                    js = assets['js'] || [],
                    html = data.result,
                    cssLen = css.length,
                    jsLen = js.length;


                var next = function() {
                    $target.html(html);

                    if(callback) {
                        callback();
                    }
                };

                var loadDone = pageCommon.loadDone(cssLen, jsLen, next);

                if(cssLen > 0) {
                    for(var i = 0, max = cssLen; i < max; i += 1) {
                        if(!_assets.hasOwnProperty(css[i])) {
                            pageCommon.cssLoad(css[i], loadDone, loadDone);
                        }else {
                            loadDone();
                        }
                    }
                }

                if(jsLen > 0) {
                    for(var i = 0, max = jsLen; i < max; i += 1) {
                        if(!_assets.hasOwnProperty(css[i])) {
                            pageCommon.jsLoad(js[i], loadDone, loadDone);
                        }else {
                            loadDone();
                        }
                    }
                }

                if((cssLen + jsLen) === 0) {
                    next();
                }

            }, 'json');
        }
    };

    /**
     * @param {object} options
     * <pre>
     *     - url        : {string} html file path
     *     - type       : {string} default 'post'
     * </pre>
     * @param {function} callback
     * */
    XE.pageModal = function(options, callback) {

    };

})(jQuery, window, XE);