;(function($, exports, XE, DynamicLoadManager) {
    var self = this;

    var _pageCommon = function() {
        return {
            init: function () {
                self = this;
                self.bindEvent();

                return this;
            },
            bindEvent: function () {
                $(document).on('click', '[data-toggle=xe-page]', self.execPage);
                $(document).on('click', '[data-toggle=xe-page-modal]', self.execPageModal);
                $(document).on('click', '[data-toggle=xe-page-toggle-menu]', self.execPageToggleMenu);
            },
            execPage: function(e) {
                e.preventDefault();

                var $this = $(this),
                    targetSelector = $this.data('target'),
                    data = $this.data('params'),
                    callback = $this.data('callback'),
                    url = $this.data('url');

                data = data? (typeof data === "object")? data : JSON.parse(data) : {};

                var objStack = callback? callback.split(".") : [];
                var callbackFunc = (objStack.length > 0)? window : '';

                var options = {
                    data: data
                };

                if(!url
                    && $this.get(0).tagName === "A"
                    && $this.attr("href")) {
                    data.url = $this.attr('href');
                }

                if(!url) {
                    url = $this.attr('href');
                }

                if(objStack.length > 0) {
                    for(var i = 0, max = objStack.length; i < max; i += 1) {
                        callbackFunc = callbackFunc[objStack[i]];
                    }
                }

                XE.page(url, targetSelector, options, callbackFunc);
            },
            execPageModal: function (e) {
                e.preventDefault();

                var $this = $(this),
                    data = $this.data('data'),
                    callback = $this.data('callback'),
                    url = $this.data('url');

                data = data? (typeof data === "object")? data : JSON.parse(data) : {};

                var objStack = callback? callback.split(".") : [];
                var callbackFunc = (objStack.length > 0)? window : '';

                var options = {
                    data: data
                };

                if(!url
                    && $this.get(0).tagName === "A"
                    && $this.attr("href")) {
                    data.url = $this.attr('href');
                }

                if(objStack.length > 0) {
                    for(var i = 0, max = objStack.length; i < max; i += 1) {
                        callbackFunc = callbackFunc[objStack[i]];
                    }
                }

                XE.pageModal(url, options, callbackFunc);
            },
            execPageToggleMenu: function (e) {
                e.preventDefault();

                var $this = $(this),
                    data = $this.data('data'),
                    targetSelector = $this.data('target'),
                    callback = $this.data('callback'),
                    url = $this.data('url');

                data = data? (typeof data === "object")? data : JSON.parse(data) : {};

                // target 을 찾을 대 parent() 에서 한번 찾고 다음엔 전체에서 찾음
                var $target;
                if (targetSelector) {
                    $target = $this.parent().find(targetSelector);
                }
                if ($target.length == 0) {
                    $target = $(targetSelector);
                }
                if ($target.length == 0) {
                    console.error('pageToggleMenu: target not found.');
                }

                var objStack = callback? callback.split(".") : [];
                var callbackFunc = (objStack.length > 0)? window : '';

                var options = {
                    data: data
                };

                if(!url
                    && $this.get(0).tagName === "A"
                    && $this.attr("href")) {
                    data.url = $this.attr('href');
                }

                if(objStack.length > 0) {
                    for(var i = 0, max = objStack.length; i < max; i += 1) {
                        callbackFunc = callbackFunc[objStack[i]];
                    }
                }

                XE.pageToggleMenu(url, $target, options, callbackFunc);
            },
            loadDone: function(cssLen, jsLen, next) {
                var loadingCount = 0;

                return function(e) {

                    loadingCount++;

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
            },
            getLayerPopupTemplate: function() {
                return [
                    '<ul class="xe-toggle-menu-items"></ul>'
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
            },
            isValidPageToggleMenu: function (options) {
                var isValid = true;

                if (!options.hasOwnProperty('url') || options.url === '') {
                    console.error('pageToggleMenu: Require option [url]');
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
        var $target = options.target;
        if (typeof $target == 'string') {
            $target = $($target);
        }

        var defaultOptions = {
            url: options.url
            , type: options.type || 'get'
            , dataType: 'json'
            , data: options.data || {}
        };

        var options = $.extend(defaultOptions, {
            success: function(data) {
                var assets = data['XE_ASSET_LOAD'] || {},
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
                        DynamicLoadManager.cssLoad(css[i], loadDone, loadDone);
                    }
                }

                if(jsLen > 0) {
                    for(var i = 0, max = jsLen; i < max; i += 1) {
                        DynamicLoadManager.jsLoad(js[i], loadDone, loadDone);
                    }
                }

                if((cssLen + jsLen) === 0) {
                    next();
                }
            }
            // , 공통에서 처리함
            // error: function(data) {
            //     XE.Progress.done();
            //
            //     XE.toast(data.type, data.message);
            // }
        });

        XE.ajax(options);

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

    /**
     * @param {string} url
     * @param {string} target : attach destination
     * @param {object} options
     * <pre>
     *     - data : request parameters
     *     - type : http method (get | post) default 'get'
     * </pre>
     * @param {function} callback
     * @description
     * <pre>
     *     실행하여 .xe-toggle-menu-items 영역에 html을 로드하고 .xe-toggle-popup 을 보여준다. html 랜더링 전에 assets파일들의 로드가 선행된다.
     *
     *     동작 순서
     *     1)css로드 + js로드
     *     2)html string append
     *     3)callback 실행
     *     4)modal show
     * </pre>
     * */
    XE.pageToggleMenu = function(url, target, options, callback) {

        var options = $.extend(options, {
            target: target,
            url: url,
            type: options.type || 'get'
        });

        if(_validation.isValidPageToggleMenu(options)) {

            var $container = target.find(".xe-toggle-menu-items");

            if($container.length > 0) {
                $container.empty();
            }else {
                var toggleMenuTemplate = _pageCommon.getLayerPopupTemplate();

                target.append(toggleMenuTemplate);
            }

            target.addClass('ly_popup');

            _page(options, function() {
                if(callback) {
                    callback();
                }

                target.css('display', 'block');
            });

        }
    };

})(jQuery, window, XE, DynamicLoadManager);