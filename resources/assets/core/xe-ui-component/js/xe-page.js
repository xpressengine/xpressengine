(function($, exports, XE) {
    var self = this;
    var _assets = {
        src: {}
    };

    var _pageCommon = function() {
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

            getModalTemplate: function() {
                return [
                    '<div class="xe-modal" data-use="xe-page">',
                        '<div class="xe-modal-dialog ">',
                            '<div class="xe-modal-content"></div>',
                        '</div>',
                    '</div>'
                ].join("\n");
            }
        }.init();
    }();

    /**
     * @description validtion
     * */
    var _validation = function() {
        return {
            isValidPage: function(options) {
                var isValid = true;

                if(!options.hasOwnProperty('url') || options.url === '') {
                    console.error('page: 필수 option [url]');
                }

                return isValid;
            },
            isValidPageModal: function(options) {
                var isValid = true;

                if(!options.hasOwnProperty('url') || options.url === '') {
                    console.error('pageModal: 필수 option [url]');
                }

                return isValid;
            }
        };
    }();

    /**
     * @param {object} options
     * <pre>
     *     - target   : {string} css selector
     *     - url        : {stirng} html file path
     *     - type       : {string} method
     * </pre>
     * @param {function} callback
     * */
    var _page = function(options, callback) {

        var $target = $(options.target);

        XE.Request[options.type](options.url, options.data || {}, function(data) {

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

            var loadDone = _pageCommon.loadDone(cssLen, jsLen, next);

            if(cssLen > 0) {
                for(var i = 0, max = cssLen; i < max; i += 1) {
                    if(!_assets.hasOwnProperty(css[i])) {
                        _pageCommon.cssLoad(css[i], loadDone, loadDone);
                    }else {
                        loadDone();
                    }
                }
            }

            if(jsLen > 0) {
                for(var i = 0, max = jsLen; i < max; i += 1) {
                    if(!_assets.hasOwnProperty(css[i])) {
                        _pageCommon.jsLoad(js[i], loadDone, loadDone);
                    }else {
                        loadDone();
                    }
                }
            }

            if((cssLen + jsLen) === 0) {
                next();
            }

        }, 'json');

    };

    /**
     *
     * @param {string} url
     * @param {string} target selector
     * @param {object} options
     * <pre>
     *     - data : request parameters
     *     - type : http method (get | post) default 'get'
     * </pre>
     * @param {function} callback
     * @description
     * <pre>
     *     selecor영역에 html을 로드하여 보여준다. html 랜더링 전에 assets파일들의 로드가 선행된다.
     *
     *     동작 순서
     *     1)css로드 + js로드
     *     2)html string append
     *     3)callback 실행
     * </pre>
     * */
    XE.page = function(url, target, options, callback) {
        var options = $.extend(options, {
            url: url,
            target: target,
            type: options.type || 'get'
        });

        if(_validation.isValidPage(options)) {
            _page(options, callback);
        }
    };

    /**
     * @param {string} url
     * @param {object} options
     * <pre>
     *     - data : request parameters
     *     - type : http method (get | post) default 'get'
     * </pre>
     * @param {function} callback
     * @description
     * <pre>
     *     modal을 실행하여 .xe-modal-content 영역에 html을 로드하여 보여준다. html 랜더링 전에 assets파일들의 로드가 선행된다.
     *
     *     동작 순서
     *     1)css로드 + js로드
     *     2)html string append
     *     3)callback 실행
     *     4)modal show
     * </pre>
     * */
    XE.pageModal = function(url, options, callback) {

        var options = $.extend(options, {
            target: ".xe-modal[data-use=xe-page] .xe-modal-content",
            url: url,
            type: options.type || 'get'
        });

        if(_validation.isValidPageModal(options)) {
            var $modal = $(".xe-modal[data-use=xe-page]");

            if($modal.length > 0) {
                $modal.find(".xe-modal-content").empty();
            }else {
                var modalTemplate = _pageCommon.getModalTemplate();

                $("body").append(modalTemplate);
            }

            _page(options, function() {
                if(callback) {
                    callback();
                }

                $(".xe-modal[data-use=xe-page]").xeModal();
            });

        }
    };

})(jQuery, window, XE);