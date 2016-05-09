/*!
 * William DURAND <william.durand1@gmail.com>
 * MIT Licensed
 */
var Translator = (function(document, undefined) {
    "use strict";

    var _messages     = {},
        _domains      = [],
        _sPluralRegex = new RegExp(/^\w+\: +(.+)$/),
        _cPluralRegex = new RegExp(/^\s*((\{\s*(\-?\d+[\s*,\s*\-?\d+]*)\s*\})|([\[\]])\s*(-Inf|\-?\d+)\s*,\s*(\+?Inf|\-?\d+)\s*([\[\]]))\s?(.+?)$/),
        _iPluralRegex = new RegExp(/^\s*(\{\s*(\-?\d+[\s*,\s*\-?\d+]*)\s*\})|([\[\]])\s*(-Inf|\-?\d+)\s*,\s*(\+?Inf|\-?\d+)\s*([\[\]])/);

    /**
     * Replace placeholders in given message.
     *
     * **WARNING:** used placeholders are removed.
     *
     * @param {String} message      The translated message
     * @param {Object} placeholders The placeholders to replace
     * @return {String}             A human readable message
     * @api private
     */
    function replace_placeholders(message, placeholders) {
        var _i,
            _prefix = Translator.placeHolderPrefix,
            _suffix = Translator.placeHolderSuffix;

        for (_i in placeholders) {
            var _r = new RegExp(_prefix + _i + _suffix, 'g');

            if (_r.test(message)) {
                message = message.replace(_r, placeholders[_i]);
            }
        }

        return message;
    }

    /**
     * Get the message based on its id, its domain, and its locale. If domain or
     * locale are not specified, it will try to find the message using fallbacks.
     *
     * @param {String} id               The message id
     * @param {String} domain           The domain for the message or null to guess it
     * @param {String} locale           The locale or null to use the default
     * @param {String} currentLocale    The current locale or null to use the default
     * @param {String} localeFallback   The fallback (default) locale
     * @return {String}                 The right message if found, `undefined` otherwise
     * @api private
     */
    function get_message(id, domain, locale, currentLocale, localeFallback) {
        var _locale = locale || currentLocale || localeFallback,
            _domain = domain;

        if (undefined == _messages[_locale]) {
            if (undefined == _messages[localeFallback]) {
                return id;
            }

            _locale = localeFallback;
        }

        if (undefined === _domain || null === _domain) {
            for (var i = 0; i < _domains.length; i++) {
                if (has_message(_locale, _domains[i], id) ||
                    has_message(localeFallback, _domains[i], id)) {
                    _domain = _domains[i];

                    break;
                }
            }
        }

        if (has_message(_locale, _domain, id)) {
            return _messages[_locale][_domain][id];
        }

        var _length, _parts, _last, _lastLength;

        while (_locale.length > 2) {
            _length     = _locale.length;
            _parts      = _locale.split(/[\s_]+/);
            _last       = _parts[_parts.length - 1];
            _lastLength = _last.length;

            if (1 === _parts.length) {
                break;
            }

            _locale = _locale.substring(0, _length - (_lastLength + 1));

            if (has_message(_locale, _domain, id)) {
                return _messages[_locale][_domain][id];
            }
        }

        if (has_message(localeFallback, _domain, id)) {
            return _messages[localeFallback][_domain][id];
        }

        return id;
    }

    /**
     * Just look for a specific locale / domain / id if the message is available,
     * helpful for message availability validation
     *
     * @param {String} locale           The locale
     * @param {String} domain           The domain for the message
     * @param {String} id               The message id
     * @return {Boolean}                Return `true` if message is available,
     *                      `               false` otherwise
     * @api private
     */
    function has_message(locale, domain, id) {
        if (undefined == _messages[locale]) {
            return false;
        }

        if (undefined == _messages[locale][domain]) {
            return false;
        }

        if (undefined == _messages[locale][domain][id]) {
            return false;
        }

        return true;
    }

    /**
     * The logic comes from the Symfony2 PHP Framework.
     *
     * Given a message with different plural translations separated by a
     * pipe (|), this method returns the correct portion of the message based
     * on the given number, the current locale and the pluralization rules
     * in the message itself.
     *
     * The message supports two different types of pluralization rules:
     *
     * interval: {0} There is no apples|{1} There is one apple|]1,Inf] There is %count% apples
     * indexed:  There is one apple|There is %count% apples
     *
     * The indexed solution can also contain labels (e.g. one: There is one apple).
     * This is purely for making the translations more clear - it does not
     * affect the functionality.
     *
     * The two methods can also be mixed:
     *     {0} There is no apples|one: There is one apple|more: There is %count% apples
     *
     * @param {String} message  The message id
     * @param {Number} number   The number to use to find the indice of the message
     * @param {String} locale   The locale
     * @return {String}         The message part to use for translation
     * @api private
     */
    function pluralize(message, number, locale) {
        var _p,
            _e,
            _explicitRules = [],
            _standardRules = [],
            _parts         = message.split(Translator.pluralSeparator),
            _matches       = [];

        for (_p = 0; _p < _parts.length; _p++) {
            var _part = _parts[_p];

            if (_cPluralRegex.test(_part)) {
                _matches = _part.match(_cPluralRegex);
                _explicitRules[_matches[0]] = _matches[_matches.length - 1];
            } else if (_sPluralRegex.test(_part)) {
                _matches = _part.match(_sPluralRegex);
                _standardRules.push(_matches[1]);
            } else {
                _standardRules.push(_part);
            }
        }

        for (_e in _explicitRules) {
            if (_iPluralRegex.test(_e)) {
                _matches = _e.match(_iPluralRegex);

                if (_matches[1]) {
                    var _ns = _matches[2].split(','),
                        _n;

                    for (_n in _ns) {
                        if (number == _ns[_n]) {
                            return _explicitRules[_e];
                        }
                    }
                } else {
                    var _leftNumber  = convert_number(_matches[4]);
                    var _rightNumber = convert_number(_matches[5]);

                    if (('[' === _matches[3] ? number >= _leftNumber : number > _leftNumber) &&
                        (']' === _matches[6] ? number <= _rightNumber : number < _rightNumber)) {
                        return _explicitRules[_e];
                    }
                }
            }
        }

        return _standardRules[plural_position(number, locale)] || _standardRules[0] || undefined;
    }

    /**
     * The logic comes from the Symfony2 PHP Framework.
     *
     * Convert number as String, "Inf" and "-Inf"
     * values to number values.
     *
     * @param {String} number   A literal number
     * @return {Number}         The int value of the number
     * @api private
     */
    function convert_number(number) {
        if ('-Inf' === number) {
            return Number.NEGATIVE_INFINITY;
        } else if ('+Inf' === number || 'Inf' === number) {
            return Number.POSITIVE_INFINITY;
        }

        return parseInt(number, 10);
    }

    /**
     * The logic comes from the Symfony2 PHP Framework.
     *
     * Returns the plural position to use for the given locale and number.
     *
     * @param {Number} number  The number to use to find the indice of the message
     * @param {String} locale  The locale
     * @return {Number}        The plural position
     * @api private
     */
    function plural_position(number, locale) {
        var _locale = locale;

        if ('pt_BR' === _locale) {
            _locale = 'xbr';
        }

        if (_locale.length > 3) {
            _locale = _locale.split('_')[0];
        }

        switch (_locale) {
            case 'bo':
            case 'dz':
            case 'id':
            case 'ja':
            case 'jv':
            case 'ka':
            case 'km':
            case 'kn':
            case 'ko':
            case 'ms':
            case 'th':
            case 'tr':
            case 'vi':
            case 'zh':
                return 0;
            case 'af':
            case 'az':
            case 'bn':
            case 'bg':
            case 'ca':
            case 'da':
            case 'de':
            case 'el':
            case 'en':
            case 'eo':
            case 'es':
            case 'et':
            case 'eu':
            case 'fa':
            case 'fi':
            case 'fo':
            case 'fur':
            case 'fy':
            case 'gl':
            case 'gu':
            case 'ha':
            case 'he':
            case 'hu':
            case 'is':
            case 'it':
            case 'ku':
            case 'lb':
            case 'ml':
            case 'mn':
            case 'mr':
            case 'nah':
            case 'nb':
            case 'ne':
            case 'nl':
            case 'nn':
            case 'no':
            case 'om':
            case 'or':
            case 'pa':
            case 'pap':
            case 'ps':
            case 'pt':
            case 'so':
            case 'sq':
            case 'sv':
            case 'sw':
            case 'ta':
            case 'te':
            case 'tk':
            case 'ur':
            case 'zu':
                return (number == 1) ? 0 : 1;

            case 'am':
            case 'bh':
            case 'fil':
            case 'fr':
            case 'gun':
            case 'hi':
            case 'ln':
            case 'mg':
            case 'nso':
            case 'xbr':
            case 'ti':
            case 'wa':
                return ((number === 0) || (number == 1)) ? 0 : 1;

            case 'be':
            case 'bs':
            case 'hr':
            case 'ru':
            case 'sr':
            case 'uk':
                return ((number % 10 == 1) && (number % 100 != 11)) ? 0 : (((number % 10 >= 2) && (number % 10 <= 4) && ((number % 100 < 10) || (number % 100 >= 20))) ? 1 : 2);

            case 'cs':
            case 'sk':
                return (number == 1) ? 0 : (((number >= 2) && (number <= 4)) ? 1 : 2);

            case 'ga':
                return (number == 1) ? 0 : ((number == 2) ? 1 : 2);

            case 'lt':
                return ((number % 10 == 1) && (number % 100 != 11)) ? 0 : (((number % 10 >= 2) && ((number % 100 < 10) || (number % 100 >= 20))) ? 1 : 2);

            case 'sl':
                return (number % 100 == 1) ? 0 : ((number % 100 == 2) ? 1 : (((number % 100 == 3) || (number % 100 == 4)) ? 2 : 3));

            case 'mk':
                return (number % 10 == 1) ? 0 : 1;

            case 'mt':
                return (number == 1) ? 0 : (((number === 0) || ((number % 100 > 1) && (number % 100 < 11))) ? 1 : (((number % 100 > 10) && (number % 100 < 20)) ? 2 : 3));

            case 'lv':
                return (number === 0) ? 0 : (((number % 10 == 1) && (number % 100 != 11)) ? 1 : 2);

            case 'pl':
                return (number == 1) ? 0 : (((number % 10 >= 2) && (number % 10 <= 4) && ((number % 100 < 12) || (number % 100 > 14))) ? 1 : 2);

            case 'cy':
                return (number == 1) ? 0 : ((number == 2) ? 1 : (((number == 8) || (number == 11)) ? 2 : 3));

            case 'ro':
                return (number == 1) ? 0 : (((number === 0) || ((number % 100 > 0) && (number % 100 < 20))) ? 1 : 2);

            case 'ar':
                return (number === 0) ? 0 : ((number == 1) ? 1 : ((number == 2) ? 2 : (((number >= 3) && (number <= 10)) ? 3 : (((number >= 11) && (number <= 99)) ? 4 : 5))));

            default:
                return 0;
        }
    }

    /**
     * @type {Array}        An array
     * @type {String}       An element to compare
     * @return {Boolean}    Return `true` if `array` contains `element`,
     *                      `false` otherwise
     * @api private
     */
    function exists(array, element) {
        for (var i = 0; i < array.length; i++) {
            if (element === array[i]) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the current application's locale based on the `lang` attribute
     * on the `html` tag.
     *
     * @return {String}     The current application's locale
     * @api private
     */
    function get_current_locale() {
        return document.documentElement.lang.replace('-', '_');
    }

    return {
        /**
         * The current locale.
         *
         * @type {String}
         * @api public
         */
        locale: get_current_locale(),

        /**
         * Fallback locale.
         *
         * @type {String}
         * @api public
         */
        fallback: 'en',

        /**
         * Placeholder prefix.
         *
         * @type {String}
         * @api public
         */
        placeHolderPrefix: '%',

        /**
         * Placeholder suffix.
         *
         * @type {String}
         * @api public
         */
        placeHolderSuffix: '%',

        /**
         * Default domain.
         *
         * @type {String}
         * @api public
         */
        defaultDomain: 'messages',

        /**
         * Plural separator.
         *
         * @type {String}
         * @api public
         */
        pluralSeparator: '|',

        /**
         * Adds a translation entry.
         *
         * @param {String} id         The message id
         * @param {String} message    The message to register for the given id
         * @param {String} [domain]   The domain for the message or null to use the default
         * @param {String} [locale]   The locale or null to use the default
         * @return {Object}           Translator
         * @api public
         */
        add: function(id, message, domain, locale) {
            var _locale = locale || this.locale || this.fallback,
                _domain = domain || this.defaultDomain;

            if (!_messages[_locale]) {
                _messages[_locale] = {};
            }

            if (!_messages[_locale][_domain]) {
                _messages[_locale][_domain] = {};
            }

            _messages[_locale][_domain][id] = message;

            if (false === exists(_domains, _domain)) {
                _domains.push(_domain);
            }

            return this;
        },


        /**
         * Translates the given message.
         *
         * @param {String} id               The message id
         * @param {Object} [parameters]     An array of parameters for the message
         * @param {String} [domain]         The domain for the message or null to guess it
         * @param {String} [locale]         The locale or null to use the default
         * @return {String}                 The translated string
         * @api public
         */
        trans: function(id, parameters, domain, locale) {
            var _message = get_message(
                id,
                domain,
                locale,
                this.locale,
                this.fallback
            );

            return replace_placeholders(_message, parameters || {});
        },

        /**
         * Translates the given choice message by choosing a translation according to a number.
         *
         * @param {String} id               The message id
         * @param {Number} number           The number to use to find the indice of the message
         * @param {Object} [parameters]     An array of parameters for the message
         * @param {String} [domain]         The domain for the message or null to guess it
         * @param {String} [locale]         The locale or null to use the default
         * @return {String}                 The translated string
         * @api public
         */
        transChoice: function(id, number, parameters, domain, locale) {
            var _message = get_message(
                id,
                domain,
                locale,
                this.locale,
                this.fallback
            );

            var _number  = parseInt(number, 10);

            if (undefined != _message && !isNaN(_number)) {
                _message = pluralize(
                    _message,
                    _number,
                    locale || this.locale || this.fallback
                );
            }

            return replace_placeholders(_message, parameters || {});
        },

        /**
         * Loads translations from JSON.
         *
         * @param {String} data     A JSON string or object literal
         * @return {Object}         Translator
         * @api public
         */
        fromJSON: function(data) {
            if (typeof data === 'string') {
                data = JSON.parse(data);
            }

            if (data.locale) {
                this.locale = data.locale;
            }

            if (data.fallback) {
                this.fallback = data.fallback;
            }

            if (data.defaultDomain) {
                this.defaultDomain = data.defaultDomain;
            }

            if (data.translations) {
                for (var locale in data.translations) {
                    for (var domain in data.translations[locale]) {
                        for (var id in data.translations[locale][domain]) {
                            this.add(id, data.translations[locale][domain][id], domain, locale);
                        }
                    }
                }
            }

            return this;
        },

        /**
         * @api public
         */
        reset: function() {
            _messages   = {};
            _domains    = [];
            this.locale = get_current_locale();
        }
    };
})(document, undefined);

if (typeof window.define === 'function' && window.define.amd) {
    window.define('translator', [], function() {
        return Translator;
    });
}

if(typeof System.amdDefine === 'function') {
  System.amdDefine('translator', [], function() {
      return Translator;
  });
}

// Export the Translator object for Node.js
if (typeof exports !== 'undefined') {
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = Translator;
    }
}

System.amdDefine('xe.component', [], function() {

  var loadedCSS = {
    'xe.modal': false
  };

  return {
    timeago: timeago
  };

  $(function() {
    /*
     * @Component Timeago
     *
     * <span data-xe-timeago="{timestmap|ISO8601}">2016-04-04 07:05:44</span>
     * <span data-xe-timeago="{timestmap|ISO8601}" title="2016-04-04 07:05:44" />3 Hours ago</span>
     */
    System.import('vendor:/moment').then(function(moment) {
      moment.locale(XE.getLocale());
    });

    
    
    $(document).on('xe.timeago', '[data-xe-timeago]', function() {
      var $this = $(this);
      if($this.data().xeTimeagoCalled === true) false;

      System.import('vendor:/moment').then(function(moment) {
        var dataDate = $this.data('xe-timeago');
        var isTimestamp = (parseInt(dataDate) == dataDate);

        if(isTimestamp) {
          dataDate = moment.unix(dataDate);
        } else {
          dataDate = moment(dataDate);
        }

        $this.text(dataDate.fromNow());
        $this.data().xeTimeagoCalled = true;
      });
    });

    boot();
  });

  function boot() {
    timeago();
  }

  function timeago() {
    $('[data-xe-timeago]').trigger('xe.timeago');
  };

});

(function($) {
  var loadedCSS = false;

  // xeModal =========================================================
  $.fn.xeModal = function(options) {
    var $el = this;

    System.import("xe.component.modal").then(function() {
      $el.xeModal(options);
    });

    if(!loadedCSS) {
      XE.cssLoad("/assets/core/xe-ui-component/xe-ui-component.css");
      loadedCSS = true;
    }
  };

  // xeDropdown ======================================================
  $.fn.xeDropdown = function(options) {
    var $el = this;

    System.import("xe.component.dropdown").then(function() {
      $el.xeDropdown(options);
    });

    if(!loadedCSS) {
      XE.cssLoad("/assets/core/xe-ui-component/xe-ui-component.css");
      loadedCSS = true;
    }
  };

  // xeTooltip =======================================================
  $.fn.xeTooltip = function(options) {
    var $el = this;

    System.import("xe.component.tooltip").then(function() {
      $el.xeTooltip(options);
    });

    if(!loadedCSS) {
      XE.cssLoad("/assets/core/xe-ui-component/xe-ui-component.css");
      loadedCSS = true;
    }
  };

})(jQuery);

(function(exports) {
    'use strict';

    //define시 필수 구현되어야 하는 object
    var requireOptions = [
            'name', 'editorType', 'editorRoot',
            'getContents', 'setContents',
            'initialize'
        ],
        editorSet = {},
        editorType = [],
        editorOptionSet = {};

    var instanceObj = function(editorName, sel, options) {
        this.editorName = editorName;
        this.selector = sel;
        this.options = options;

    };

    instanceObj.prototype = {
        props: {},
        getInstance: function() {
            return editorSet[this.editorName].editorList[this.selector];
        },
        getContents: function() {
            return editorSet[this.editorName].getContents.call(this.getInstance());
        },
        setContents: function() {
            editorSet[this.editorName].setContents.bind(this.getInstance());
        },
        addProps: function(obj) {
            for(var o in obj) {
                //this['props'][o] = obj[o];
                this.getInstance().props[o] = obj[o];
            }
        }
    };

    var Editor = function(options) {
        this.name = options.name;
        this.editorType = options.editorType;
        this.editor = options.editor;
        this.editorList = {};

        for(var o in options) {
            this[o] = options[o];
        }
    };

    Editor.prototype = {
        create: function(sel, options) {
            this.editorList[sel] = new instanceObj(this.name, sel, options);
            this.initialize.call(this.editorList[sel], sel, options);

            return this.editorList[sel];
        },
        getContents: function() {
            console.error('Editor.getContents');
        },
        setContents: function() {
            console.error('Editor.setContents');
        }
    };

    var XEeditor = {
        define: function(options) {
            if(this.isValidOptions(options)) {
                editorOptionSet[options.name] = options;
                editorSet[options.name] = new Editor(options);
            }
        },
        isValidOptions: function(options) {
            var valid = true;
            for(var option in requireOptions) {
                if(!options.hasOwnProperty(requireOptions[option])) {
                    console.error('구현 필요 [fn:' + requireOptions[option] + ']');
                    valid = false;
                }
            }

            if(!!editorSet.hasOwnProperty(options.name)) {
                console.error('등록된 에디터 있음 [' + options.name + ']');
                valid = false;
            }

            if(!valid) {
                return false;
            }

            return true;
        },
        getEditor: function(name) {
            return editorSet[name];
        },
        setEditorType: function(types) {

            if(types instanceof Array) {

            }else if(typeof types === 'string'){

            }

        }
    };

    exports.XEeditor = XEeditor;
})(window);




//xe.lang.js
System.amdDefine('xe.lang', ['translator'], function(Translator) {
  'use strict';

  var self = this,
      _items = {};

  return {
    locales: [],
    set: set,
    setLocales: setLocales,
    getLangCode: getLangCode,
    trans: trans,
    transChoice: transChoice
  };

  Translator.placeHolderPrefix = ':';
  Translator.placeHolderSuffix = '';

  // var Lang = {};
  function setLocales(locales) {
    this.locales = locales;
    Translator.locale = (locales.length > 0)? locales[0] : 'en';
  }

  function set(items) {
    $.extend(_items, items);
    $.each(_items, function(key, value) {
      Translator.add(key, value);
    });
  };

  function getLangCode(locale) {
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

  function trans(id, parameters) {
    return Translator.trans(id, parameters);
  };

  function transChoice(id, number, parameters) {
    return Translator.transChoice(id, number, parameters);
  };

});

System.amdDefine('queue', [], function() {

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

});

System.amdDefine('css', [], function() {
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
  };

});

System.amdDefine('xe.progress', ['css', 'queue'], function(css, queue) {
  'use strict'

  var instances = [];

  return {
    cssLoad: cssLoad,
    start: start,
    done: done
  };



  // @TODO 라이브러리 분리
  // 다중 인스턴스를 위해 수정된 상태임

  var cssLoaded = false;
  function cssLoad() {
    if (cssLoaded === false) {
      cssLoaded = true;
      XE.cssLoad('/assets/core/common/css/progress.css'); // @TODO
    }
  };

  function start(context) {
    this.cssLoad();``

    var $context = $(context);
    if ($context.context === undefined) {
      $context = $('body');
    }

    setInstance($context);

    $context.trigger('progressStart');
  };

  function done(context) {
    var $context = $(context);
    if ($context.context === undefined) {
      $context = $('body');
    }

    $context.trigger('progressDone');
  };

  exports.spinner = function(context) {

  };

  exports.clearSpinner = function(context) {

  };



  function getInstance($context) {
    var instanceId = $context.attr('data-progress-instance');

    var instance = null;
    if (instanceId != undefined) {
      instance = instances[instanceId];
    }

    return instance;
  };

  function getCount($context) {
    var count = $context.attr('data-progress-count');

    if (count != undefined) {
      count = parseInt(count);
    }
    return count;
  };

  function setCount($context, count) {
    if (parseInt(count) < 0) {
      count = 0;
    }
    $context.attr('data-progress-count', count);
  }

  function setInstance($context, instance) {
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

  function attachInstance($context) {
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
  function XeProgress() {
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



  /**
   * Helpers
   */
  function clamp(n, min, max) {
    if (n < min) return min;
    if (n > max) return max;
    return n;
  }

  function toBarPerc(n) {
    return (-1 + n) * 100;
  }



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
});

System.amdDefine('xe.request', ['xe.progress'], function(Progress) {

  var _options = {
    headers : {
      'X-CSRF-TOKEN': null
    }
  };

  // @FIXME
  $(document).ajaxSend(function(event, jqxhr, settings) {
    Progress.start(settings.context == undefined ? $('body') : settings.context);
  }).ajaxComplete(function(event, jqxhr, settings) {
    Progress.done(settings.context == undefined ? $('body') : settings.context);
  }).ajaxError(function(event, jqxhr, settings, thrownError) {
    window.error(jqxhr, settings, thrownError);
  });

  return {
    setup: setup,
    get: get,
    post: post,
    options: _options
  };

  function setup(options) {
    $.extend(_options, options);
    $.ajaxSetup(_options);
  }

  function get(url, data, callback, type) {
    return $.get(url, data, callback, type)
  }

  function post(url, data, callback, type) {
    return $.post(url, data, callback, type);
  }

  function error(jqxhr, settings, thrownError) {
    var status = jqxhr.status,
      type = 'danger',
      errorMessage = 'Not defined error message ('+status+')';

    // @TODO dataType 에 따라 메시지 획득 방식을 추가 해야함.
    if (settings.dataType == 'json') {
      errorMessage = $.parseJSON(jqxhr.responseText).message;
    } else {
      errorMessage = jqxhr.statusText;
    }

    // @FIXME 의존성
    window.XE.toastByStatus(status, errorMessage);
  }

});

(function(exports) {
  'use strict';

  var self,
      _options;


  var XE = {
    initialize: initialize,
    setup: setup,
    configure: configure,
    cssLoad: cssLoad,
    toast: toast,
    toastByStatus: toastByStatus,
    formError: formError,
    formErrorClear: formErrorClear,
    validate: validate,
    getLocale: getLocale,
    getDefaultLocale: getDefaultLocale,

    options: {},

    Lang: '',
    Progress: '',
    Request: '',
    Component: ''
  };


  exports.XE = XE;

  return XE;

  /**
   * @description
   * <pre>
   *     XE module initialize
   * </pre>
   * */
  function initialize() {

    self = this;
    _options = {};
    _loadXEModule();

    return this;
  }


  function _loadXEModule() {
    System.amdRequire(['xe.lang', 'xe.progress', 'xe.request', 'xe.component'], function(lang, progress, request, component) {

      self.Lang = lang;
      self.Progress = progress;
      self.Request = request;
      self.Component = component;

      self.ajax = self.Request.ajax = function(url, options) {
        if ( typeof url === "object" ) {
          options = $.extend({}, self.Request.options, url);
          url = undefined;
        } else {
          options = $.extend({}, options, self.Request.options, {url: url});
          url = undefined;
        }

        $.ajaxSetup(options);
        var jqXHR = $.ajax(url, options);
        return jqXHR;
      };
    });
  }

  /**
   * @param {object} options
   * */
  function setup(options) {
    _options.loginUserId = options.loginUserId;
    self.options.loginUserId = options.loginUserId;

    self.Request.setup({
      headers: {
        'X-CSRF-TOKEN': options['X-CSRF-TOKEN']
      }
    });
  }

  /**
   * @param {object} options
   * */
  function configure(options) {
    $.extend(_options, options);
    $.extend(self.options, options);
  }

  // @DEPRECATED
  function cssLoad(url) {
    $('head').append($('<link>').attr('rel', 'stylesheet').attr('href', url));
  }

  function toast(type, message) {
    if (type == '') {
      type = 'danger';
    }
    System.import('xecore:/common/js/modules/griper/griper').then(function (griper) {
      return griper.toast(type, message);
    });
  }

  function toastByStatus(status, message) {
    System.import('xecore:/common/js/modules/griper/griper').then(function (griper) {
      return griper.toast(griper.toast.fn.statusToType(status), message);
    });
  }

  function formError($element, message) {
    System.import('xecore:/common/js/modules/griper/griper').then(function (griper) {
      return griper.form($element, message);
    });
  }

  function formErrorClear($form) {
    System.import('xecore:/common/js/modules/griper/griper').then(function (griper) {
      return griper.form.fn.clear($form);
    });
  }

  function validate($form) {
    System.import('xecore:/common/js/modules/validator').then(function (validator) {
      validator.validate($form);
    });
  }
  //
  // function import(name, parentName, parentAddress) {
  //   if(_.isArray(name)) {
  //     var modules = _.map(name, function(module){
  //       return System.import(module);
  //     });
  //     return Promise.all(modules);
  //   } else {
  //     return System.import(name);
  //   }
  // }

  function getLocale() {
    return _options.locale;
  }

  function getDefaultLocale() {
    return _options.defaultLocale;
  }

  if(this.Request) {

  }

    // $.ajaxPrefilter(function(options, originalOptions, jqXHR ) {
    //   $.extend(options, self.Request.options);
    // });


})(window).initialize();
