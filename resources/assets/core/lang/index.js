import App from 'xe/app'
import Translator from 'xe-common/translator' // @FIXME https://github.com/xpressengine/xpressengine/issues/765
import $ from 'jquery'
import * as $$ from 'xe/utils'
import config from 'xe/config'

/**
 * @class
 * @extends App
 * @requires Translator
 */
class Lang extends App {
  constructor () {
    super()

    Translator.placeHolderPrefix = ':'
    Translator.placeHolderSuffix = ''

    this.locales = [] // @FIXME
  }

  static appName () {
    return 'Lang'
  }

  boot (XE, options) {
    if (this.booted()) {
      return Promise.resolve(this)
    }

    return new Promise((resolve) => {
      super.boot(XE)
      if (options.translation.locales) {
        this.$$config.dispatch('lang/setLocales', {
          locales: options.translation.locales,
          default: options.defaultLocale,
          current: options.locale
        })
      }

      this.locales = this.$$config.getters['lang/locales'] || []

      if (options.translation) {
        this.set(options.translation.terms)
      }

      resolve(this)
    })
  }

  /**
  * 번역리스트를 Translator 객체에 담는다.
  * @param {object} items
  */
  set (items) {
    $.each(items, function (key, value) {
      Translator.add(key, value)
    })
  }

  /**
  * Locale을 세팅한다.
  * @param {locales} locales
  */
  setLocales (locales) {
    this.locales = locales
    Translator.locale = (locales.length > 0) ? locales[0] : 'en'
  }

  /**
  * language code를 반환한다.
  * @param {string} locale
  * @return {string}
  */
  getLangCode (locale) {
    return locale ? _items[locale] : _items
  }

  /**
  * 현재 선택된 locale 정보를 반환한다.
  * @return {string}
  */
  getCurrentLocale () {
    return this.$$config.getters['lang/current'].code
  }

  /**
  * 등록된 번역 id에 대한 번역 메시지를 반환한다.
  * @param {string} id
  * @param {object} parameters
  * @return {string}
  */
  trans (id, parameters) {
    return Translator.trans(id, parameters)
  }

  /**
  * 동적으로 번역 id에 해당하는 메시지를 가져와 callback으로 반환한다.
  * @param {string} id
  * @param {object} parameters
  * @param {function} callback @deprecated
  * @return {Promise}
  */
  requestTrans (id, parameters, callback) {
    const that = this
    const item = id.split('::')[1]
    let message = ''

    return new Promise((resolve, reject) => {
      this.$$xe.get('/lang/lines/' + item).then((response) => {
        if (Array.isArray(response.data)) {
          message = $$.find(response.data, { 'locale': this.locales[0] }).value
          Translator.add(id, message)
        }

        resolve(message)
        if (typeof callback === 'function') {
          callback(item, message) // @deprecated
        }
      })
    })
  }

  /**
  * id list로 번역리스트를 요청한다.
  * @param {array} langKeys
  * @param {function} callback @deprecated
  * @return {Promise}
  */
  requestTransAll (langKeys, callback) {
    const result = {}
    const that = this

    return new Promise((resolve, reject) => {
      this.$$xe.get(this.$$config.getters['router/origin'] + '/lang/lines/many', { keys: langKeys }).then(response => {
        $$.forEach(response.data, (val, key) => {
          if (val.length) {
            result[key] = $$.find(val, { 'locale': config.getters['lang/current'].code }).value
            Translator.add(key, result[key])
          }
        })

        resolve(result)
        if (typeof callback === 'function') {
          callback(response.data, result) // @deprecated
        }
      })
    })
  }

  /**
  * number에 따라 번역을 선택하여 주어진 메시지를 전달한다.
  * @param {string} id
  * @param {number} number
  * @param {object} parameters
  */
  transChoice (id, number, parameters) {
    return Translator.transChoice(id, number, parameters)
  }
}

export default Lang

const _items = {
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
  zu: 'zu-ZA'
}
