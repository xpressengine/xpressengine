var XE = (function(window, document, jquery) {
    'use strict';

    var XE = {},
        $ = jquery.noConflict(true);

    // jquery 를 구분하기 위해 버전 변경
    $.jquery = $.jquery + '.XE';

    XE.$ = XE.jQuery = $;

    XE.options = {
        loadedTime: null,
        nowTime: parseInt(new Date().getTime() / 1000),
        timeLag: null
    };

    XE.setup = function (options) {
        this.options.loginUserId = options.loginUserId;
        this.options.loadedTime = options.loadedTime;
        this.options.timeLag = options.loadedTime - XE.options.nowTime;

        this.Request.setup({
            headers: {
                'X-CSRF-TOKEN': options['X-CSRF-TOKEN']
            }
        });
    };

    XE.configure = function (options) {
        $.extend(XE.options, options);
    };

    XE.cssLoad = function(url) {
        //$('<link>').attr('rel', 'stylesheet').attr('href', url).appendTo('head');
        $('head').append($('<link>').attr('rel', 'stylesheet').attr('href', url));
    };

    XE.toast = function (type, message) {
        if (type == '') {
            type = 'danger';
        }
        require(['griper'], function (griper) {
            return griper.toast(type, message);
        });
    };

    XE.toastByStatus = function (status, message) {
        require(['griper'], function (griper) {
            return griper.toast(griper.toast.fn.statusToType(status), message);
        });
    };

    XE.formError = function ($element, message) {
        require(['griper'], function (griper) {
            return griper.form($element, message);
        });
    };

    XE.formError.clear = function ($form) {
        require(['griper'], function (griper) {
            return griper.form.fn.clear($form);
        });
    };

    XE.validate = function ($form) {
        require(['validator'], function (validator) {
            validator.validate($form);
        });
    };

    window.XE = XE;
    return XE;
}(this, this.document, jQuery));

XE.Request = (function(XE, $) {
    'use strict';

    var Request = {};

    Request.options = {
        headers : {
            'X-CSRF-TOKEN': null
        }
    };

    $.ajaxPrefilter(function(options, originalOptions, jqXHR ) {
        $.extend(options, XE.Request.options);
    });

    $(document).ajaxSend(function(event, jqxhr, settings) {
        XE.Progress.start(settings.context == undefined ? $('body') : settings.context);
    }).ajaxComplete(function(event, jqxhr, settings) {
        XE.Progress.done(settings.context == undefined ? $('body') : settings.context);
    }).ajaxError(function(event, jqxhr, settings, thrownError) {
        Request.error(jqxhr, settings, thrownError);
    });

    Request.setup = function(options) {
        $.extend(this.options, options);

        // XE.$ 를 주입받아 사용해야 할 jquery 의 서드파티들...
        //$.ajaxSetup(this.options);
    };

    // XE 인터페이스 확장
    XE.ajax = Request.ajax = function(url, options) {
        if ( typeof url === "object" ) {
            options = $.extend({}, XE.Request.options, url);
            url = undefined;
        } else {
            options = $.extend({}, options, XE.Request.options, {url: url});
            url = undefined;
        }

        var jqXHR = $.ajax(url, options);
        return jqXHR;
    };

    Request.get = function(url, data, callback, type) {
        return $.get(url, data, callback, type)
    };

    Request.post = function(url, data, callback, type) {
        return $.post(url, data, callback, type);
    };

    // 여기를 많이 강화해야 한다.
    Request.error = function(jqxhr, settings, thrownError) {
        var status = jqxhr.status,
            type = 'danger',
            errorMessage = 'Not defined error message ('+status+')';

        // dataType 에 따라 메시지 획득 방식을 추가 해야함.
        if (settings.dataType == 'json') {
            errorMessage = $.parseJSON(jqxhr.responseText).message;
        } else {
            errorMessage = jqxhr.statusText;
        }

        XE.toastByStatus(status, errorMessage);
    };

    return Request;
}(XE, XE.jQuery));

XE.Lang = (function(XE, $) {
    'use strict';

    Translator.placeHolderPrefix = ':';
    Translator.placeHolderSuffix = '';

    var Lang = {};

    Lang.locales = [];
    Lang.setLocales = function(locales) {
        Lang.locales = locales;
        Translator.locale = locales.length > 0 ? locales[0] : 'en';
    };

    Lang.items = {};
    Lang.set = function(items) {
        $.extend(Lang.items, items);
        $.each(Lang.items, function(key, value) {
            Translator.add(key, value);
        });
    };

    Lang.getLangCode = function (locale) {
        var list = {
            'af' : 'af-ZA',
            'ar' : 'ar-SA',
            'az' : 'az-AZ',
            'be' : 'be-BY',
            'bg' : 'bg-BG',
            'bs' : 'bs-BA',
            'ca' : 'ca-ES',
            'cs' : 'cs-CZ',
            'cy' : 'cy-GB',
            'da' : 'da-DK',
            'de' : 'de-DE',
            'dv' : 'dv-MV',
            'el' : 'el-GR',
            'en' : 'en-US',
            'es' : 'es-ES',
            'et' : 'et-EE',
            'eu' : 'eu-ES',
            'fa' : 'fa-IR',
            'fi' : 'fi-FI',
            'fo' : 'fo-FO',
            'fr' : 'fr-FR',
            'gl' : 'gl-ES',
            'gu' : 'gu-IN',
            'he' : 'he-IL',
            'hi' : 'hi-IN',
            'hr' : 'hr-HR',
            'hu' : 'hu-HU',
            'hy' : 'hy-AM',
            'id' : 'id-ID',
            'is' : 'is-IS',
            'it' : 'it-IT',
            'ja' : 'ja-JP',
            'ka' : 'ka-GE',
            'kk' : 'kk-KZ',
            'kn' : 'kn-IN',
            'ko' : 'ko-KR',
            'kok' : 'kok-IN',
            'ky' : 'ky-KG',
            'lt' : 'lt-LT',
            'lv' : 'lv-LV',
            'mi' : 'mi-NZ',
            'mk' : 'mk-MK',
            'mn' : 'mn-MN',
            'mr' : 'mr-IN',
            'ms' : 'ms-MY',
            'mt' : 'mt-MT',
            'nb' : 'nb-NO',
            'nl' : 'nl-NL',
            'nn' : 'nn-NO',
            'ns' : 'ns-ZA',
            'pa' : 'pa-IN',
            'pl' : 'pl-PL',
            'ps' : 'ps-AR',
            'pt' : 'pt-PT',
            'qu' : 'qu-EC',
            'ro' : 'ro-RO',
            'ru' : 'ru-RU',
            'sa' : 'sa-IN',
            'se' : 'se-SE',
            'sk' : 'sk-SK',
            'sl' : 'sl-SI',
            'sq' : 'sq-AL',
            'sr' : 'sr-SP',
            'sv' : 'sv-SE',
            'sw' : 'sw-KE',
            'syr' : 'syr-SY',
            'ta' : 'ta-IN',
            'te' : 'te-IN',
            'th' : 'th-TH',
            'tl' : 'tl-PH',
            'tn' : 'tn-ZA',
            'tr' : 'tr-TR',
            'tt' : 'tt-RU',
            'uk' : 'uk-UA',
            'ur' : 'ur-PK',
            'uz' : 'uz-UZ',
            'vi' : 'vi-VN',
            'xh' : 'xh-ZA',
            'zh' : 'zh-CN',
            'zu' : 'zu-ZA'
        };

        return locale ? list[locale] : list;
    };

    Lang.trans = function(id, parameters) {
        return Translator.trans(id, parameters);
    };

    Lang.transChoice = function(id, number, parameters) {
        return Translator.transChoice(id, number, parameters);
    };

    return Lang;
}(XE, XE.jQuery));

XE.Progress = (function(XE, $) {
    'use strict';

    var Progress = {}

    var cssLoaded = false;
    Progress.cssLoad = function() {
        if (cssLoaded === false) {
            cssLoaded = true;
            XE.cssLoad('/assets/vendor/core/css/progress.css');
        }
    };

    Progress.start = function(context) {
        this.cssLoad();

        var $context = $(context);
        if ($context.context === undefined) {
            $context = $('body');
        }

        setInstance($context);

        $context.trigger('progressStart');
    };

    Progress.done = function(context) {
        var $context = $(context);
        if ($context.context === undefined) {
            $context = $('body');
        }

        $context.trigger('progressDone');
    };

    Progress.spinner = function(context) {

    };

    Progress.clearSpinner = function(context) {

    };

    var instances = [];

    var getInstance = function($context) {
        var instanceId = $context.attr('data-progress-instance');

        var instance = null;
        if (instanceId != undefined) {
            instance = instances[instanceId];
        }

        return instance;
    };

    var getCount = function($context) {
        var count = $context.attr('data-progress-count');

        if (count != undefined) {
            count = parseInt(count);
        }
        return count;
    };

    var setCount = function($context, count) {
        if (parseInt(count) < 0) {
            count = 0;
        }
        $context.attr('data-progress-count', count);
    }

    var setInstance = function($context, instance) {
        if (getInstance($context) === null) {
            var progress = new XeProgress(),
                parent = 'body',
                type = $context.data('progress-type') === undefined ? 'default' : $context.data('progress-type'),
                showSpinner = type !== 'nospin';


            if ($context.attr('id') !== undefined) {
                parent = '#' + $context.attr('id');
            } else if($context.selector !== undefined) {
                parent = $context.selector;
            }

            progress.configure({
                parent: parent,
                type:  type,
                showSpinner: showSpinner
            });
            instances.push(progress);
            var instanceId = instances.length - 1;
            $context.attr('data-progress-instance', instanceId);

            progress.setInstanceId(instanceId);

            setCount($context, 0);
            attachInstance($context);
        }
    };

    var attachInstance = function($context) {
        $context.bind('progressStart', function(e) {
            e.stopPropagation();
            var count = getCount($context);
            setCount($context, count+1);
            if (count === 0) {
                getInstance($context).start();
            }

        });

        $context.bind('progressDone', function(e) {
            e.stopPropagation();

            var count = getCount($context);

            setCount($(this), count-1);
            if (count === 1) {
                var instance = getInstance($context);
                instance.done(instance.getTime());
            }
        });
    };


    /**
     * progress bar 없이 spinner 만 사용
     */
    var xeSpinner = function() {

    };

    /**
     * NProgress, (c) 2013, 2014 Rico Sta. Cruz - http://ricostacruz.com/nprogress
     * @license MIT
     *
     * NProgress 모듈을 instance 화 할 수 있도록 하기위해 수정함
     * */
    var XeProgress = function() {
        this.settings = {
            type: 'default',    // defautl, cover, nospin
            minimum: 0.08,
            easing: 'ease',
            positionUsing: '',
            speed: 200,
            trickle: true,
            trickleRate: 0.02,
            trickleSpeed: 800,
            showSpinner: true,
            barSelector: '[role="bar"]',
            spinnerSelector: '[role="spinner"]',
            parent: 'body',
            template: {
                default: '<div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div>',
                cover: '<div class="cover" role="bar"><div class="peg"></div></div><div class="spinner spinner-center" role="spinner"><div class="spinner-icon"></div></div>'
            }
        };

        this.$progress = null;
        this.$bar = null;
        this.status = null;
        this.initial =  0;
        this.current = 0;
        this.instanceId = null;
        this.time = null;

        this.setInstanceId = function(instanceId) {
            this.instanceId = instanceId
        };

        this.configure = function(options) {
            $.extend(this.settings, options);
        };

        this.getTime = function() {
            return this.time;
        };

        this.start = function() {
            if (!this.status) {
                this.time = new Date().getTime();
                this.set(0);
            }

            var self = this;

            var work = function() {
                setTimeout(function() {
                    if (!self.status) return;
                    self.trickle();
                    work();
                }, self.settings.trickleSpeed);
            };

            if (this.settings.trickle) work();

            return this;
        };

        this.done = function(time, force) {
            if (this.time != time) {
                return this;
            }

            if (!force && !this.status) return this;

            return this.inc(0.3 + 0.5 * Math.random()).set(1);
        };

        this.inc = function(amount) {
            var n = this.status;

            if (!n) {
                return this.start();
            } else {
                if (typeof amount !== 'number') {
                    amount = (1 - n) * clamp(Math.random() * n, 0.1, 0.95);
                }

                n = clamp(n + amount, 0, 0.994);
                return this.set(n);
            }
        };

        this.set = function(n) {
            var started = this.isStarted();

            n = clamp(n, this.settings.minimum, 1);
            this.status = (n === 1 ? null : n);

            var $progress = this.render(!started),
                $bar      = this.$bar,
                speed    = this.settings.speed,
                ease     = this.settings.easing;

            // $progress.offsetWidth; /* Repaint */

            var self = this,
                time = this.getTime();
            queue(function(next) {
                // Set positionUsing if it hasn't already been set
                if (self.settings.positionUsing === '') self.settings.positionUsing = self.getPositioningCSS();

                // Add transition
                css(self.$bar, barPositionCSS(n, speed, ease, self.settings));

                if (n === 1) {
                    // Fade out
                    css(self.$progress, {
                        transition: 'none',
                        opacity: 1
                    });
                    //$progress.offsetWidth; /* Repaint */

                    setTimeout(function() {
                        css(self.$progress, {
                            transition: 'all ' + speed + 'ms linear',
                            opacity: 0
                        });
                        setTimeout(function() {
                            self.remove(time);
                            next();
                        }, speed);
                    }, speed);
                } else {
                    setTimeout(next, speed);
                }
            });
            return this;
        };

        this.isStarted = function() {
            return typeof this.status === 'number';
        };

        this.promise = function($promise) {
            if (!$promise || $promise.state() === "resolved") {
                return this;
            }

            if (this.current === 0) {
                this.start();
            }

            this.initial++;
            this.current++;

            var self = this;
            $promise.always(function() {
                self.current--;
                if (self.current === 0) {
                    self.initial = 0;
                    self.done(this.time);
                } else {
                    self.set((self.initial - self.current) / self.initial);
                }
            });

            return this;
        };

        this.trickle = function() {
            return this.inc(Math.random() * this.settings.trickleRate);
        };

        this.render = function(fromStart) {
            //if (this.isRendered()) {
            //    return $(this.settings.parent).children('.xe-progress');
            //}

            if (this.isRendered()) {
                return this.$progress;
            }

            var $progress = $('<div>');
            $progress.addClass('xe-progress');
            if (this.settings.template[this.settings.type] === undefined) {
                this.settings.type = 'default';
            }
            $progress.html(this.settings.template[this.settings.type]);

            var $bar      = $progress.find(this.settings.barSelector),
                perc     = fromStart ? '-100' : toBarPerc(this.status || 0),
                $parent   = $(this.settings.parent),
                $spinner;

            $bar.attr('title-name', this.instanceId);
            this.$bar = $bar;

            css($bar, {
                transition: 'all 0 linear',
                transform: 'translate3d(' + perc + '%,0,0)'
            });

            if (!this.settings.showSpinner) {
                $spinner = $progress.find(this.settings.spinnerSelector);
                $spinner && $spinner.remove();
            }

            $parent.addClass('xe-progress-'+this.settings.type);
            if ($parent.is('body') === false) {
                $parent.addClass('xe-progress-custom-parent');
            }

            this.$progress = $progress;

            $parent.append($progress);
            return $progress;
        };

        /**
         * Removes the element. Opposite of render().
         */
        this.remove = function(time) {
            this.done(time);

            $(this.settings.parent).removeClass('xe-progress-custom-parent xe-progress-'+this.settings.type);

            if (this.$progress != null) {
                this.$progress.remove();
            }


            this.$progress = null;
            this.$bar = null;
        };

        /**
         * Checks if the progress bar is rendered.
         */
        this.isRendered = function() {
            //return !!$(this.settings.parent).children('.xe-progress').length;
            return this.$progress !== null;
        };

        /**
         * Determine which positioning CSS rule to use.
         */
        this.getPositioningCSS = function() {
            var bodyStyle = document.body.style;

            // Sniff prefixes
            var vendorPrefix = ('WebkitTransform' in bodyStyle) ? 'Webkit' :
                ('MozTransform' in bodyStyle) ? 'Moz' :
                    ('msTransform' in bodyStyle) ? 'ms' :
                        ('OTransform' in bodyStyle) ? 'O' : '';

            if (vendorPrefix + 'Perspective' in bodyStyle) {
                // Modern browsers with 3D support, e.g. Webkit, IE10
                return 'translate3d';
            } else if (vendorPrefix + 'Transform' in bodyStyle) {
                // Browsers without 3D support, e.g. IE9
                return 'translate';
            } else {
                // Browsers without translate() support, e.g. IE7-8
                return 'margin';
            }
        }
    };

    var css = (function() {
        var cssPrefixes = [ 'Webkit', 'O', 'Moz', 'ms' ],
            cssProps    = {};

        function camelCase(string) {
            return string.replace(/^-ms-/, 'ms-').replace(/-([\da-z])/gi, function(match, letter) {
                return letter.toUpperCase();
            });
        }

        function getVendorProp(name) {
            var style = document.body.style;
            if (name in style) return name;

            var i = cssPrefixes.length,
                capName = name.charAt(0).toUpperCase() + name.slice(1),
                vendorName;
            while (i--) {
                vendorName = cssPrefixes[i] + capName;
                if (vendorName in style) return vendorName;
            }

            return name;
        }

        function getStyleProp(name) {
            name = camelCase(name);
            return cssProps[name] || (cssProps[name] = getVendorProp(name));
        }

        function applyCss(element, prop, value) {
            prop = getStyleProp(prop);
            if (element) {
                element[0].style[prop] = value;
            }
        }

        return function(element, properties) {
            var args = arguments,
                prop,
                value;

            if (args.length == 2) {
                for (prop in properties) {
                    value = properties[prop];
                    if (value !== undefined && properties.hasOwnProperty(prop)) applyCss(element, prop, value);
                }
            } else {
                applyCss(element, args[1], args[2]);
            }
        }
    })();

    /**
     * Helpers
     */
    var clamp = function(n, min, max) {
        if (n < min) return min;
        if (n > max) return max;
        return n;
    };

    function toBarPerc(n) {
        return (-1 + n) * 100;
    }

    var queue = (function() {
        var pending = [];

        function next() {
            var fn = pending.shift();
            if (fn) {
                fn(next);
            }
        }

        return function(fn) {
            pending.push(fn);
            if (pending.length == 1) next();
        };
    })();

    function barPositionCSS(n, speed, ease, Settings) {
        var barCSS;

        if (Settings.positionUsing === 'translate3d') {
            barCSS = { transform: 'translate3d('+toBarPerc(n)+'%,0,0)' };
        } else if (Settings.positionUsing === 'translate') {
            barCSS = { transform: 'translate('+toBarPerc(n)+'%,0)' };
        } else {
            barCSS = { 'margin-left': toBarPerc(n)+'%' };
        }

        barCSS.transition = 'all '+speed+'ms '+ease;

        return barCSS;
    }

    return Progress;
}(XE, XE.jQuery));


/**
 * XE 의 jquery 를 global jquery 로 설정.
 * jquery 를 서드파티에서 다시 load 할 경우 변경 될 수 있으므로 core 에서는 XE.$ 를 사용하도록 함
 */
$ = jQuery = XE.$;