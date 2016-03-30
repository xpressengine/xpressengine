(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    define(['exports', 'xecore:/common/js/translator'], factory);
  } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
    // CommonJS
    factory(exports, require('xecore:/common/js/translator'));
  } else {
    factory((root.XeLang = {}), root.translator);
  }
}(this, function (exports, Translator) {
  'use strict';

  Translator.placeHolderPrefix = ':';
  Translator.placeHolderSuffix = '';

  // var Lang = {};

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

  exports.getLangCode = function (locale) {
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

  exports.trans = function(id, parameters) {
    return Translator.trans(id, parameters);
  };

  exports.transChoice = function(id, number, parameters) {
    return Translator.transChoice(id, number, parameters);
  };
}));
