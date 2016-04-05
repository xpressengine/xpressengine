!function(e){function r(e,r,o){return 4===arguments.length?t.apply(this,arguments):void n(e,{declarative:!0,deps:r,declare:o})}function t(e,r,t,o){n(e,{declarative:!1,deps:r,executingRequire:t,execute:o})}function n(e,r){r.name=e,e in p||(p[e]=r),r.normalizedDeps=r.deps}function o(e,r){if(r[e.groupIndex]=r[e.groupIndex]||[],-1==v.call(r[e.groupIndex],e)){r[e.groupIndex].push(e);for(var t=0,n=e.normalizedDeps.length;n>t;t++){var a=e.normalizedDeps[t],u=p[a];if(u&&!u.evaluated){var d=e.groupIndex+(u.declarative!=e.declarative);if(void 0===u.groupIndex||u.groupIndex<d){if(void 0!==u.groupIndex&&(r[u.groupIndex].splice(v.call(r[u.groupIndex],u),1),0==r[u.groupIndex].length))throw new TypeError("Mixed dependency cycle detected");u.groupIndex=d}o(u,r)}}}}function a(e){var r=p[e];r.groupIndex=0;var t=[];o(r,t);for(var n=!!r.declarative==t.length%2,a=t.length-1;a>=0;a--){for(var u=t[a],i=0;i<u.length;i++){var s=u[i];n?d(s):l(s)}n=!n}}function u(e){return x[e]||(x[e]={name:e,dependencies:[],exports:{},importers:[]})}function d(r){if(!r.module){var t=r.module=u(r.name),n=r.module.exports,o=r.declare.call(e,function(e,r){if(t.locked=!0,"object"==typeof e)for(var o in e)n[o]=e[o];else n[e]=r;for(var a=0,u=t.importers.length;u>a;a++){var d=t.importers[a];if(!d.locked)for(var i=0;i<d.dependencies.length;++i)d.dependencies[i]===t&&d.setters[i](n)}return t.locked=!1,r},r.name);t.setters=o.setters,t.execute=o.execute;for(var a=0,i=r.normalizedDeps.length;i>a;a++){var l,s=r.normalizedDeps[a],c=p[s],v=x[s];v?l=v.exports:c&&!c.declarative?l=c.esModule:c?(d(c),v=c.module,l=v.exports):l=f(s),v&&v.importers?(v.importers.push(t),t.dependencies.push(v)):t.dependencies.push(null),t.setters[a]&&t.setters[a](l)}}}function i(e){var r,t=p[e];if(t)t.declarative?c(e,[]):t.evaluated||l(t),r=t.module.exports;else if(r=f(e),!r)throw new Error("Unable to load dependency "+e+".");return(!t||t.declarative)&&r&&r.__useDefault?r["default"]:r}function l(r){if(!r.module){var t={},n=r.module={exports:t,id:r.name};if(!r.executingRequire)for(var o=0,a=r.normalizedDeps.length;a>o;o++){var u=r.normalizedDeps[o],d=p[u];d&&l(d)}r.evaluated=!0;var c=r.execute.call(e,function(e){for(var t=0,n=r.deps.length;n>t;t++)if(r.deps[t]==e)return i(r.normalizedDeps[t]);throw new TypeError("Module "+e+" not declared as a dependency.")},t,n);c&&(n.exports=c),t=n.exports,t&&t.__esModule?r.esModule=t:r.esModule=s(t)}}function s(r){if(r===e)return r;var t={};if("object"==typeof r||"function"==typeof r)if(g){var n;for(var o in r)(n=Object.getOwnPropertyDescriptor(r,o))&&h(t,o,n)}else{var a=r&&r.hasOwnProperty;for(var o in r)(!a||r.hasOwnProperty(o))&&(t[o]=r[o])}return t["default"]=r,h(t,"__useDefault",{value:!0}),t}function c(r,t){var n=p[r];if(n&&!n.evaluated&&n.declarative){t.push(r);for(var o=0,a=n.normalizedDeps.length;a>o;o++){var u=n.normalizedDeps[o];-1==v.call(t,u)&&(p[u]?c(u,t):f(u))}n.evaluated||(n.evaluated=!0,n.module.execute.call(e))}}function f(e){if(D[e])return D[e];if("@node/"==e.substr(0,6))return y(e.substr(6));var r=p[e];if(!r)throw"Module "+e+" not present.";return a(e),c(e,[]),p[e]=void 0,r.declarative&&h(r.module.exports,"__esModule",{value:!0}),D[e]=r.declarative?r.module.exports:r.esModule}var p={},v=Array.prototype.indexOf||function(e){for(var r=0,t=this.length;t>r;r++)if(this[r]===e)return r;return-1},g=!0;try{Object.getOwnPropertyDescriptor({a:0},"a")}catch(m){g=!1}var h;!function(){try{Object.defineProperty({},"a",{})&&(h=Object.defineProperty)}catch(e){h=function(e,r,t){try{e[r]=t.value||t.get.call(e)}catch(n){}}}}();var x={},y="undefined"!=typeof System&&System._nodeRequire||"undefined"!=typeof require&&require.resolve&&"undefined"!=typeof process&&require,D={"@empty":{}};return function(e,n,o){return function(a){a(function(a){for(var u={_nodeRequire:y,register:r,registerDynamic:t,get:f,set:function(e,r){D[e]=r},newModule:function(e){return e}},d=0;d<n.length;d++)(function(e,r){r&&r.__esModule?D[e]=r:D[e]=s(r)})(n[d],arguments[d]);o(u);var i=f(e[0]);if(e.length>1)for(var d=1;d<e.length;d++)f(e[d]);return i.__useDefault?i["default"]:i})}}}("undefined"!=typeof self?self:global)

(["1"], [], function($__System, require) {

$__System.registerDynamic("2", [], true, function($__require, exports, module) {
  ;
  var define,
      global = this,
      GLOBAL = this;
  var Translator = (function(document, undefined) {
    "use strict";
    var _messages = {},
        _domains = [],
        _sPluralRegex = new RegExp(/^\w+\: +(.+)$/),
        _cPluralRegex = new RegExp(/^\s*((\{\s*(\-?\d+[\s*,\s*\-?\d+]*)\s*\})|([\[\]])\s*(-Inf|\-?\d+)\s*,\s*(\+?Inf|\-?\d+)\s*([\[\]]))\s?(.+?)$/),
        _iPluralRegex = new RegExp(/^\s*(\{\s*(\-?\d+[\s*,\s*\-?\d+]*)\s*\})|([\[\]])\s*(-Inf|\-?\d+)\s*,\s*(\+?Inf|\-?\d+)\s*([\[\]])/);
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
          if (has_message(_locale, _domains[i], id) || has_message(localeFallback, _domains[i], id)) {
            _domain = _domains[i];
            break;
          }
        }
      }
      if (has_message(_locale, _domain, id)) {
        return _messages[_locale][_domain][id];
      }
      var _length,
          _parts,
          _last,
          _lastLength;
      while (_locale.length > 2) {
        _length = _locale.length;
        _parts = _locale.split(/[\s_]+/);
        _last = _parts[_parts.length - 1];
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
    function pluralize(message, number, locale) {
      var _p,
          _e,
          _explicitRules = [],
          _standardRules = [],
          _parts = message.split(Translator.pluralSeparator),
          _matches = [];
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
            var _leftNumber = convert_number(_matches[4]);
            var _rightNumber = convert_number(_matches[5]);
            if (('[' === _matches[3] ? number >= _leftNumber : number > _leftNumber) && (']' === _matches[6] ? number <= _rightNumber : number < _rightNumber)) {
              return _explicitRules[_e];
            }
          }
        }
      }
      return _standardRules[plural_position(number, locale)] || _standardRules[0] || undefined;
    }
    function convert_number(number) {
      if ('-Inf' === number) {
        return Number.NEGATIVE_INFINITY;
      } else if ('+Inf' === number || 'Inf' === number) {
        return Number.POSITIVE_INFINITY;
      }
      return parseInt(number, 10);
    }
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
    function exists(array, element) {
      for (var i = 0; i < array.length; i++) {
        if (element === array[i]) {
          return true;
        }
      }
      return false;
    }
    function get_current_locale() {
      return document.documentElement.lang.replace('-', '_');
    }
    return {
      locale: get_current_locale(),
      fallback: 'en',
      placeHolderPrefix: '%',
      placeHolderSuffix: '%',
      defaultDomain: 'messages',
      pluralSeparator: '|',
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
      trans: function(id, parameters, domain, locale) {
        var _message = get_message(id, domain, locale, this.locale, this.fallback);
        return replace_placeholders(_message, parameters || {});
      },
      transChoice: function(id, number, parameters, domain, locale) {
        var _message = get_message(id, domain, locale, this.locale, this.fallback);
        var _number = parseInt(number, 10);
        if (undefined != _message && !isNaN(_number)) {
          _message = pluralize(_message, _number, locale || this.locale || this.fallback);
        }
        return replace_placeholders(_message, parameters || {});
      },
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
      reset: function() {
        _messages = {};
        _domains = [];
        this.locale = get_current_locale();
      }
    };
  })(document, undefined);
  if (typeof window.define === 'function' && window.define.amd) {
    window.define('Translator', [], function() {
      return Translator;
    });
  }
  if (typeof exports !== 'undefined') {
    if (typeof module !== 'undefined' && module.exports) {
      module.exports = Translator;
    }
  }
  return module.exports;
});

$__System.registerDynamic("3", ["2"], true, function($__require, exports, module) {
  ;
  var define,
      global = this,
      GLOBAL = this;
  (function(root, factory) {
    if (typeof define === 'function' && define.amd) {
      define(['exports', 'xecore:/common/js/translator'], factory);
    } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
      factory(exports, $__require('2'));
    } else {
      factory((root.XeLang = {}), root.translator);
    }
  }(this, function(exports, Translator) {
    'use strict';
    Translator.placeHolderPrefix = ':';
    Translator.placeHolderSuffix = '';
    exports.locales = [];
    exports.setLocales = function(locales) {
      exports.locales = locales;
      Translator.locale = locales.length > 0 ? locales[0] : 'en';
    };
    exports.items = {};
    exports.set = function(items) {
      $.extend(exports.items, items);
      $.each(exports.items, function(key, value) {
        Translator.add(key, value);
      });
    };
    exports.getLangCode = function(locale) {
      var list = {
        'af': 'af-ZA',
        'ar': 'ar-SA',
        'az': 'az-AZ',
        'be': 'be-BY',
        'bg': 'bg-BG',
        'bs': 'bs-BA',
        'ca': 'ca-ES',
        'cs': 'cs-CZ',
        'cy': 'cy-GB',
        'da': 'da-DK',
        'de': 'de-DE',
        'dv': 'dv-MV',
        'el': 'el-GR',
        'en': 'en-US',
        'es': 'es-ES',
        'et': 'et-EE',
        'eu': 'eu-ES',
        'fa': 'fa-IR',
        'fi': 'fi-FI',
        'fo': 'fo-FO',
        'fr': 'fr-FR',
        'gl': 'gl-ES',
        'gu': 'gu-IN',
        'he': 'he-IL',
        'hi': 'hi-IN',
        'hr': 'hr-HR',
        'hu': 'hu-HU',
        'hy': 'hy-AM',
        'id': 'id-ID',
        'is': 'is-IS',
        'it': 'it-IT',
        'ja': 'ja-JP',
        'ka': 'ka-GE',
        'kk': 'kk-KZ',
        'kn': 'kn-IN',
        'ko': 'ko-KR',
        'kok': 'kok-IN',
        'ky': 'ky-KG',
        'lt': 'lt-LT',
        'lv': 'lv-LV',
        'mi': 'mi-NZ',
        'mk': 'mk-MK',
        'mn': 'mn-MN',
        'mr': 'mr-IN',
        'ms': 'ms-MY',
        'mt': 'mt-MT',
        'nb': 'nb-NO',
        'nl': 'nl-NL',
        'nn': 'nn-NO',
        'ns': 'ns-ZA',
        'pa': 'pa-IN',
        'pl': 'pl-PL',
        'ps': 'ps-AR',
        'pt': 'pt-PT',
        'qu': 'qu-EC',
        'ro': 'ro-RO',
        'ru': 'ru-RU',
        'sa': 'sa-IN',
        'se': 'se-SE',
        'sk': 'sk-SK',
        'sl': 'sl-SI',
        'sq': 'sq-AL',
        'sr': 'sr-SP',
        'sv': 'sv-SE',
        'sw': 'sw-KE',
        'syr': 'syr-SY',
        'ta': 'ta-IN',
        'te': 'te-IN',
        'th': 'th-TH',
        'tl': 'tl-PH',
        'tn': 'tn-ZA',
        'tr': 'tr-TR',
        'tt': 'tt-RU',
        'uk': 'uk-UA',
        'ur': 'ur-PK',
        'uz': 'uz-UZ',
        'vi': 'vi-VN',
        'xh': 'xh-ZA',
        'zh': 'zh-CN',
        'zu': 'zu-ZA'
      };
      return locale ? list[locale] : list;
    };
    exports.trans = function(id, parameters) {
      return Translator.trans(id, parameters);
    };
    exports.transChoice = function(id, number, parameters) {
      return Translator.transChoice(id, number, parameters);
    };
  }));
  return module.exports;
});

$__System.registerDynamic("4", [], true, function($__require, exports, module) {
  ;
  var define,
      global = this,
      GLOBAL = this;
  (function(root, factory) {
    if (typeof define === 'function' && define.amd) {
      define(['exports'], factory);
    } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
      factory(exports);
    } else {
      factory({});
    }
  }(this, function(exports) {
    'use strict';
    var cssLoaded = false;
    exports.cssLoad = function() {
      if (cssLoaded === false) {
        cssLoaded = true;
        XE.cssLoad('/assets/core/common/css/progress.css');
      }
    };
    exports.start = function(context) {
      this.cssLoad();
      var $context = $(context);
      if ($context.context === undefined) {
        $context = $('body');
      }
      setInstance($context);
      $context.trigger('progressStart');
    };
    exports.done = function(context) {
      var $context = $(context);
      if ($context.context === undefined) {
        $context = $('body');
      }
      $context.trigger('progressDone');
    };
    exports.spinner = function(context) {};
    exports.clearSpinner = function(context) {};
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
    };
    var setInstance = function($context, instance) {
      if (getInstance($context) === null) {
        var progress = new XeProgress(),
            parent = 'body',
            type = $context.data('progress-type') === undefined ? 'default' : $context.data('progress-type'),
            showSpinner = type !== 'nospin';
        if ($context.attr('id') !== undefined) {
          parent = '#' + $context.attr('id');
        } else if ($context.selector !== undefined) {
          parent = $context.selector;
        }
        progress.configure({
          parent: parent,
          type: type,
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
        setCount($context, count + 1);
        if (count === 0) {
          getInstance($context).start();
        }
      });
      $context.bind('progressDone', function(e) {
        e.stopPropagation();
        var count = getCount($context);
        setCount($(this), count - 1);
        if (count === 1) {
          var instance = getInstance($context);
          instance.done(instance.getTime());
        }
      });
    };
    var xeSpinner = function() {};
    var XeProgress = function() {
      this.settings = {
        type: 'default',
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
      this.initial = 0;
      this.current = 0;
      this.instanceId = null;
      this.time = null;
      this.setInstanceId = function(instanceId) {
        this.instanceId = instanceId;
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
            if (!self.status)
              return;
            self.trickle();
            work();
          }, self.settings.trickleSpeed);
        };
        if (this.settings.trickle)
          work();
        return this;
      };
      this.done = function(time, force) {
        if (this.time != time) {
          return this;
        }
        if (!force && !this.status)
          return this;
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
            $bar = this.$bar,
            speed = this.settings.speed,
            ease = this.settings.easing;
        var self = this,
            time = this.getTime();
        queue(function(next) {
          if (self.settings.positionUsing === '')
            self.settings.positionUsing = self.getPositioningCSS();
          css(self.$bar, barPositionCSS(n, speed, ease, self.settings));
          if (n === 1) {
            css(self.$progress, {
              transition: 'none',
              opacity: 1
            });
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
        if (this.isRendered()) {
          return this.$progress;
        }
        var $progress = $('<div>');
        $progress.addClass('xe-progress');
        if (this.settings.template[this.settings.type] === undefined) {
          this.settings.type = 'default';
        }
        $progress.html(this.settings.template[this.settings.type]);
        var $bar = $progress.find(this.settings.barSelector),
            perc = fromStart ? '-100' : toBarPerc(this.status || 0),
            $parent = $(this.settings.parent),
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
        $parent.addClass('xe-progress-' + this.settings.type);
        if ($parent.is('body') === false) {
          $parent.addClass('xe-progress-custom-parent');
        }
        this.$progress = $progress;
        $parent.append($progress);
        return $progress;
      };
      this.remove = function(time) {
        this.done(time);
        $(this.settings.parent).removeClass('xe-progress-custom-parent xe-progress-' + this.settings.type);
        if (this.$progress != null) {
          this.$progress.remove();
        }
        this.$progress = null;
        this.$bar = null;
      };
      this.isRendered = function() {
        return this.$progress !== null;
      };
      this.getPositioningCSS = function() {
        var bodyStyle = document.body.style;
        var vendorPrefix = ('WebkitTransform' in bodyStyle) ? 'Webkit' : ('MozTransform' in bodyStyle) ? 'Moz' : ('msTransform' in bodyStyle) ? 'ms' : ('OTransform' in bodyStyle) ? 'O' : '';
        if (vendorPrefix + 'Perspective' in bodyStyle) {
          return 'translate3d';
        } else if (vendorPrefix + 'Transform' in bodyStyle) {
          return 'translate';
        } else {
          return 'margin';
        }
      };
    };
    var css = (function() {
      var cssPrefixes = ['Webkit', 'O', 'Moz', 'ms'],
          cssProps = {};
      function camelCase(string) {
        return string.replace(/^-ms-/, 'ms-').replace(/-([\da-z])/gi, function(match, letter) {
          return letter.toUpperCase();
        });
      }
      function getVendorProp(name) {
        var style = document.body.style;
        if (name in style)
          return name;
        var i = cssPrefixes.length,
            capName = name.charAt(0).toUpperCase() + name.slice(1),
            vendorName;
        while (i--) {
          vendorName = cssPrefixes[i] + capName;
          if (vendorName in style)
            return vendorName;
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
            if (value !== undefined && properties.hasOwnProperty(prop))
              applyCss(element, prop, value);
          }
        } else {
          applyCss(element, args[1], args[2]);
        }
      };
    })();
    var clamp = function(n, min, max) {
      if (n < min)
        return min;
      if (n > max)
        return max;
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
        if (pending.length == 1)
          next();
      };
    })();
    function barPositionCSS(n, speed, ease, Settings) {
      var barCSS;
      if (Settings.positionUsing === 'translate3d') {
        barCSS = {transform: 'translate3d(' + toBarPerc(n) + '%,0,0)'};
      } else if (Settings.positionUsing === 'translate') {
        barCSS = {transform: 'translate(' + toBarPerc(n) + '%,0)'};
      } else {
        barCSS = {'margin-left': toBarPerc(n) + '%'};
      }
      barCSS.transition = 'all ' + speed + 'ms ' + ease;
      return barCSS;
    }
  }));
  return module.exports;
});

$__System.registerDynamic("5", [], true, function($__require, exports, module) {
  ;
  var define,
      global = this,
      GLOBAL = this;
  (function(root, factory) {
    if (typeof define === 'function' && define.amd) {
      define(['exports'], factory);
    } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
      factory(exports);
    } else {
      factory({});
    }
  }(this, function(exports) {
    'use strict';
    var $ = window.jQuery;
    exports.options = {headers: {'X-CSRF-TOKEN': null}};
    $(document).ajaxSend(function(event, jqxhr, settings) {
      XE.Progress.start(settings.context == undefined ? $('body') : settings.context);
    }).ajaxComplete(function(event, jqxhr, settings) {
      XE.Progress.done(settings.context == undefined ? $('body') : settings.context);
    }).ajaxError(function(event, jqxhr, settings, thrownError) {
      exports.error(jqxhr, settings, thrownError);
    });
    exports.setup = function(options) {
      $.extend(exports.options, options);
      $.ajaxSetup(exports.options);
    };
    exports.get = function(url, data, callback, type) {
      return $.get(url, data, callback, type);
    };
    exports.post = function(url, data, callback, type) {
      return $.post(url, data, callback, type);
    };
    exports.error = function(jqxhr, settings, thrownError) {
      var status = jqxhr.status,
          type = 'danger',
          errorMessage = 'Not defined error message (' + status + ')';
      if (settings.dataType == 'json') {
        errorMessage = $.parseJSON(jqxhr.responseText).message;
      } else {
        errorMessage = jqxhr.statusText;
      }
      window.XE.toastByStatus(status, errorMessage);
    };
  }));
  return module.exports;
});

$__System.registerDynamic("6", [], true, function($__require, exports, module) {
  ;
  var define,
      global = this,
      GLOBAL = this;
  (function(root, factory) {
    if (typeof define === 'function' && define.amd) {
      define(['exports'], factory);
    } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
      factory(exports);
    } else {
      factory({});
    }
  }(this, function(exports, Translator) {
    'use strict';
    $(function() {
      $(document).on('xe.timeago', '[data-xe-timeago]', function() {
        var $this = $(this);
        if ($this.data().xeTimeagoCalled === true)
          false;
        System.import('xevendor:/moment/moment.min').then(function(moment) {
          console.group('@ timeago');
          var dataDate = $this.data('xe-timeago');
          var isTimestamp = (parseInt(dataDate) == dataDate);
          console.log('isTimestamp', isTimestamp);
          if (isTimestamp) {
            dataDate = moment.unix(dataDate);
          } else {
            dataDate = moment(dataDate);
          }
          console.log(dataDate);
          $this.text(dataDate.fromNow());
          $this.data().xeTimeagoCalled = true;
          console.groupEnd('@ timeago');
        });
      });
      boot();
    });
    function boot() {
      exports.timeago();
    }
    exports.timeago = function() {
      $('[data-xe-timeago]').trigger('xe.timeago');
    };
  }));
  return module.exports;
});

$__System.registerDynamic("1", ["3", "4", "5", "6"], true, function($__require, exports, module) {
  ;
  var define,
      global = this,
      GLOBAL = this;
  (function(root, factory) {
    if (typeof define === 'function' && define.amd) {
      define(['exports', 'xecore:/common/js/xe.lang', 'xecore:/common/js/xe.progress', 'xecore:/common/js/xe.request', 'xecore:/common/js/xe.component'], function(exports, $, XeLang, XeProgress, XeRequest) {
        if (typeof root.XE === "undefined") {
          factory((root.XE = exports), XeLang, XeProgress, XeRequest);
        }
      });
    } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
      if (typeof root.XE === "undefined") {
        factory((root.XE = exports), $__require('3'), $__require('4'), $__require('5'), $__require('6'));
      }
    } else {
      if (typeof root.XE === "undefined") {
        factory((root.XE = {}));
      }
    }
  }(this, function(exports, XeLang, XeProgress, XeRequest, XeComponent) {
    'use strict';
    var INSTANCE = null;
    var $ = window.jQuery;
    var XE = function() {
      var self = this;
      this.Lang = XeLang;
      this.Progress = XeProgress;
      this.Request = XeRequest;
      this.Component = XeComponent;
      this.options = {
        loadedTime: null,
        nowTime: parseInt(new Date().getTime() / 1000),
        timeLag: null
      };
      this.setup = function(options) {
        self.options.loginUserId = options.loginUserId;
        self.options.loadedTime = options.loadedTime;
        self.options.timeLag = options.loadedTime - self.options.nowTime;
        self.Request.setup({headers: {'X-CSRF-TOKEN': options['X-CSRF-TOKEN']}});
      };
      this.configure = function(options) {
        $.extend(self.options, options);
      };
      this.cssLoad = function(url) {
        $('head').append($('<link>').attr('rel', 'stylesheet').attr('href', url));
      };
      this.toast = function(type, message) {
        if (type == '') {
          type = 'danger';
        }
        System.import('xecore:/common/js/modules/griper/griper').then(function(griper) {
          return griper.toast(type, message);
        });
      };
      this.toastByStatus = function(status, message) {
        System.import('xecore:/common/js/modules/griper/griper').then(function(griper) {
          return griper.toast(griper.toast.fn.statusToType(status), message);
        });
      };
      this.formError = function($element, message) {
        System.import('xecore:/common/js/modules/griper/griper').then(function(griper) {
          return griper.form($element, message);
        });
      };
      this.formError.clear = function($form) {
        System.import('xecore:/common/js/modules/griper/griper').then(function(griper) {
          return griper.form.fn.clear($form);
        });
      };
      this.validate = function($form) {
        System.import('xecore:/common/js/modules/validator').then(function(validator) {
          validator.validate($form);
        });
      };
      if (this.Request) {
        self.ajax = self.Request.ajax = function(url, options) {
          if (typeof url === "object") {
            options = $.extend({}, self.Request.options, url);
            url = undefined;
          } else {
            options = $.extend({}, options, self.Request.options, {url: url});
            url = undefined;
          }
          console.log(url);
          console.log(options);
          $.ajaxSetup(options);
          var jqXHR = $.ajax(url, options);
          return jqXHR;
        };
      }
    };
    var getInstance = function() {
      if (INSTANCE === null) {
        INSTANCE = new XE();
      }
      return INSTANCE;
    };
    $.extend(exports, getInstance());
  }));
  return module.exports;
});

})
(function(factory) {
  factory();
});