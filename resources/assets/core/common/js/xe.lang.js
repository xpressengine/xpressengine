/**
 * Lang module
 * @module Lang
 * */
export default (function () {

  /** @private */
  var _items = {
    af: 'af-ZA',
    ar: 'ar-SA',
    az: 'az-AZ',
    be: 'be-BY',
    bg: 'bg-BG',
    bs: 'bs-BA',
    ca: 'ca-ES',
    cs: 'cs-CZ',
    cy: 'cy-GB',
    da: 'da-DK',
    de: 'de-DE',
    dv: 'dv-MV',
    el: 'el-GR',
    en: 'en-US',
    es: 'es-ES',
    et: 'et-EE',
    eu: 'eu-ES',
    fa: 'fa-IR',
    fi: 'fi-FI',
    fo: 'fo-FO',
    fr: 'fr-FR',
    gl: 'gl-ES',
    gu: 'gu-IN',
    he: 'he-IL',
    hi: 'hi-IN',
    hr: 'hr-HR',
    hu: 'hu-HU',
    hy: 'hy-AM',
    id: 'id-ID',
    is: 'is-IS',
    it: 'it-IT',
    ja: 'ja-JP',
    ka: 'ka-GE',
    kk: 'kk-KZ',
    kn: 'kn-IN',
    ko: 'ko-KR',
    kok: 'kok-IN',
    ky: 'ky-KG',
    lt: 'lt-LT',
    lv: 'lv-LV',
    mi: 'mi-NZ',
    mk: 'mk-MK',
    mn: 'mn-MN',
    mr: 'mr-IN',
    ms: 'ms-MY',
    mt: 'mt-MT',
    nb: 'nb-NO',
    nl: 'nl-NL',
    nn: 'nn-NO',
    ns: 'ns-ZA',
    pa: 'pa-IN',
    pl: 'pl-PL',
    ps: 'ps-AR',
    pt: 'pt-PT',
    qu: 'qu-EC',
    ro: 'ro-RO',
    ru: 'ru-RU',
    sa: 'sa-IN',
    se: 'se-SE',
    sk: 'sk-SK',
    sl: 'sl-SI',
    sq: 'sq-AL',
    sr: 'sr-SP',
    sv: 'sv-SE',
    sw: 'sw-KE',
    syr: 'syr-SY',
    ta: 'ta-IN',
    te: 'te-IN',
    th: 'th-TH',
    tl: 'tl-PH',
    tn: 'tn-ZA',
    tr: 'tr-TR',
    tt: 'tt-RU',
    uk: 'uk-UA',
    ur: 'ur-PK',
    uz: 'uz-UZ',
    vi: 'vi-VN',
    xh: 'xh-ZA',
    zh: 'zh-CN',
    zu: 'zu-ZA',
  };

  Translator.placeHolderPrefix = ':';
  Translator.placeHolderSuffix = '';

  return {
    /**
     * @memberof module:Lang
     * @type {array}
     * */
    locales: [],

    /**
     * 번역리스트를 Translator 객체에 담는다.
     * @memberof module:Lang
     * @param {object} items
     * */
    set: function (items) {
      //$.extend(_items, items);
      $.each(items, function (key, value) {
        Translator.add(key, value);
      });

    },

    /**
     * Locale을 세팅한다.
     * @memberof module:Lang
     * @param {locales} locales
     * */
    setLocales: function (locales) {
      this.locales = locales;
      Translator.locale = (locales.length > 0) ? locales[0] : 'en';
    },

    /**
     * language code를 반환한다.
     * @memberof module:Lang
     * @param {string} locale
     * @return {string}
     * */
    getLangCode: function (locale) {
      return locale ? _items[locale] : _items;
    },

    /**
     * 현재 선택된 locale 정보를 반환한다.
     * @memberof module:Lang
     * @return {string}
     * */
    getCurrentLocale: function () {
      return this.locales[0];
    },

    /**
     * 등록된 번역 id에 대한 번역 메시지를 반환한다.
     * @memberof module:Lang
     * @param {string} id
     * @param {object} parameters
     * @return {string}
     * */
    trans: function (id, parameters) {
      return Translator.trans(id, parameters);
    },

    /**
     * 동적으로 번역 id에 해당하는 메시지를 가져와 callback으로 반환한다.
     * @memberof module:Lang
     * @param {string} id
     * @param {object} parameters
     * @param {function} callback
     * */
    requestTrans: function (id, parameters, callback) {
      var _this = this;

      XE.ajax({
        url: xeBaseURL + '/' + XE.options.fixedPrefix + '/lang/lines/' + id,
        type: 'json',
        type: 'get',
        data: parameters,
        success: function (res) {
          var message = id.split('::')[1];
          var data;

          if (res.length > 0) {
            for (var i = 0, max = res.length; i < max; i += 1) {
              if (res[i].locale == XE.Lang.locales[0]) {
                data = res[i].value;
                break;
              }
            }
          }

          callback(message, data);
        },
      });
    },

    /**
     * id list로 번역리스트를 요청한다.
     * @memberof module:Lang
     * @param {array} langKeys
     * @param {function} callback
     * */
    requestTransAll: function (langKeys, callback) {
      XE.ajax({
        type: 'get',
        dataType: 'json',
        url: xeBaseURL + '/' + XE.options.fixedPrefix + '/lang/lines/many',
        data: {
          keys: langKeys,
        },
        useXeSpinner: false,
        success: function (res) {
          var result = {};

          $.each(res, (key, arr) => {
            $.each(arr, function () {
              if (this.locale === XE.Lang.locales[0]) {
                result[key] = this.value;
              }
            });
          });

          if (Object.keys(result).length > 0) {
            $.each(result, function (key, value) {
              Translator.add(key, value);
            });
          }

          if (callback) {
            callback(res, result);
          }
        },
      });
    },

    /**
     * number에 따라 번역을 선택하여 주어진 메시지를 전달한다.
     * @memberof module:Lang
     * @param {string} id
     * @param {number} number
     * @param {object} parameters
     * */
    transChoice: function (id, number, parameters) {
      return Translator.transChoice(id, number, parameters);
    },
  };

})();
