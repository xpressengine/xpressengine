/*!
 * William DURAND <william.durand1@gmail.com>
 * MIT Licensed
 */
var Translator = (function (document, undefined) {
  'use strict';

  var _messages = {};
  var _domains = [];
  var _sPluralRegex = new RegExp(/^\w+\: +(.+)$/);
  var _cPluralRegex = new RegExp(/^\s*((\{\s*(\-?\d+[\s*,\s*\-?\d+]*)\s*\})|([\[\]])\s*(-Inf|\-?\d+)\s*,\s*(\+?Inf|\-?\d+)\s*([\[\]]))\s?(.+?)$/);
  var _iPluralRegex = new RegExp(/^\s*(\{\s*(\-?\d+[\s*,\s*\-?\d+]*)\s*\})|([\[\]])\s*(-Inf|\-?\d+)\s*,\s*(\+?Inf|\-?\d+)\s*([\[\]])/);

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
  function replacePlaceholders(message, placeholders) {
    var _i;
    var _prefix = Translator.placeHolderPrefix;
    var _suffix = Translator.placeHolderSuffix;

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
  function getMessage(id, domain, locale, currentLocale, localeFallback) {
    var _locale = locale || currentLocale || localeFallback;
    var _domain = domain;

    if (_messages[_locale] == undefined) {
      if (_messages[localeFallback] == undefined) {
        // s::CUSTOM::
        var returnId = id;

        if (id.split('xe::'.toLowerCase()).length > 1) {
          returnId = id.split('xe::'.toLowerCase())[1];
        }

        return returnId;
      }

      _locale = localeFallback;
    }

    if (_domain === undefined || _domain === null) {
      for (var i = 0; i < _domains.length; i++) {
        if (hasMessage(_locale, _domains[i], id) ||
          hasMessage(localeFallback, _domains[i], id)) {
          _domain = _domains[i];

          break;
        }
      }
    }

    if (hasMessage(_locale, _domain, id)) {
      return _messages[_locale][_domain][id];
    }

    var _length;
    var _parts;
    var _last;
    var _lastLength;

    while (_locale.length > 2) {
      _length = _locale.length;
      _parts = _locale.split(/[\s_]+/);
      _last = _parts[_parts.length - 1];
      _lastLength = _last.length;

      if (_parts.length === 1) {
        break;
      }

      _locale = _locale.substring(0, _length - (_lastLength + 1));

      if (hasMessage(_locale, _domain, id)) {
        return _messages[_locale][_domain][id];
      }
    }

    if (hasMessage(localeFallback, _domain, id)) {
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
  function hasMessage(locale, domain, id) {
    if (_messages[locale] == undefined) {
      return false;
    }

    if (_messages[locale][domain] == undefined) {
      return false;
    }

    if (_messages[locale][domain][id] == undefined) {
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
    var _p;
    var _e;
    var _explicitRules = [];
    var _standardRules = [];
    var _parts = message.split(Translator.pluralSeparator);
    var _matches = [];

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
          var _ns = _matches[2].split(',');
          var _n;

          for (_n in _ns) {
            if (number == _ns[_n]) {
              return _explicitRules[_e];
            }
          }
        } else {
          var _leftNumber = convertNumber(_matches[4]);
          var _rightNumber = convertNumber(_matches[5]);

          if ((_matches[3] === '[' ? number >= _leftNumber : number > _leftNumber) &&
            (_matches[6] === ']' ? number <= _rightNumber : number < _rightNumber)) {
            return _explicitRules[_e];
          }
        }
      }
    }

    return _standardRules[pluralPosition(number, locale)] || _standardRules[0] || undefined;
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
  function convertNumber(number) {
    if (number === '-Inf') {
      return Number.NEGATIVE_INFINITY;
    } else if (number === '+Inf' || number === 'Inf') {
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
  function pluralPosition(number, locale) {
    var _locale = locale;

    if (_locale === 'pt_BR') {
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
  function getCurrentLocale() {
    return document.documentElement.lang.replace('-', '_');
  }

  return {
    /**
     * The current locale.
     *
     * @type {String}
     * @api public
     */
    locale: getCurrentLocale(),

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
    add: function (id, message, domain, locale) {
      var _locale = locale || this.locale || this.fallback;
      var _domain = domain || this.defaultDomain;

      if (!_messages[_locale]) {
        _messages[_locale] = {};
      }

      if (!_messages[_locale][_domain]) {
        _messages[_locale][_domain] = {};
      }

      _messages[_locale][_domain][id] = message;

      if (exists(_domains, _domain) === false) {
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
    trans: function (id, parameters, domain, locale) {
      var _message = getMessage(
        id,
        domain,
        locale,
        this.locale,
        this.fallback
      );

      return replacePlaceholders(_message, parameters || {});
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
    transChoice: function (id, number, parameters, domain, locale) {
      var _message = getMessage(
        id,
        domain,
        locale,
        this.locale,
        this.fallback
      );

      var _number = parseInt(number, 10);

      if (_message && !isNaN(_number) != undefined) {
        _message = pluralize(
          _message,
          _number,
          locale || this.locale || this.fallback
        );
      }

      return replacePlaceholders(_message, parameters || {});
    },

    /**
     * Loads translations from JSON.
     *
     * @param {String} data     A JSON string or object literal
     * @return {Object}         Translator
     * @api public
     */
    fromJSON: function (data) {
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
    reset: function () {
      _messages = {};
      _domains = [];
      this.locale = getCurrentLocale();
    },
  };
})(document, undefined);
