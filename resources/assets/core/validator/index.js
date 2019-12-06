import App from 'xe/app'
import moment from 'moment'
import Translator from 'xe-common/translator' // @FIXME https://github.com/xpressengine/xpressengine/issues/765
import * as $$ from 'xe/utils'
import $ from 'jquery'
import { getForm } from 'xe/form'
import { ValidationError } from 'xe/validator/errors/validator.error.js'
import PluginMarker from './marker'

const originalRules = {}

/**
* @class
*/
class Validator extends App {
  constructor () {
    super()

    $$.eventify(this)
    let that = this

    this.rules = {}
    this.alertTypes = {}

    /**
    * validation 실패 메시지를 노출한다.
    * @property {object} evaluator
    * @property {function} evaluator.accepted
    * @property {function} evaluator.checked
    * @property {function} evaluator.required
    * @property {function} evaluator.alpha
    * @property {function} evaluator.alphanum
    * @property {function} evaluator.alpha_num
    * @property {function} evaluator.alpha_dash
    * @property {function} evaluator.array
    * @property {function} evaluator.boolean
    * @property {function} evaluator.date
    * @property {function} evaluator.date_format
    * @property {function} evaluator.digits
    * @property {function} evaluator.digits_between
    * @property {function} evaluator.filled
    * @property {function} evaluator.integer
    * @property {function} evaluator.ip
    * @property {function} evaluator.mimes
    * @property {function} evaluator.regex
    * @property {function} evaluator.json
    * @property {function} evaluator.string
    * @property {function} evaluator.min
    * @property {function} evaluator.max
    * @property {function} evaluator.email
    * @property {function} evaluator.url
    * @property {function} evaluator.numeric
    * @property {function} evaluator.between
    */
    this.evaluator = {
      accepted: function ($dst, parameters) {
        const value = that.getValue($dst)
        if (!value) return

        if (['yes', 'ok', 'accept', 'accepted', 'on', '1', 'true'].indexOf(String(value).toLowerCase()) === -1) {
          that.error($dst, that.$$xe.Lang.trans('validation.accepted', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      checked: function ($dst, parameters) {
        let [min, max] = parameters.split('-')
        let checkedLenth = $dst.clone().wrap('<div />').parent().find(':checked').length

        if (checkedLenth < parseInt(min, 10) || checkedLenth > parseInt(max, 10)) {
          let messageType = 'xe::validatorChecked'

          if (!max) {
            messageType = 'xe::validatorCheckedMin'
          } else if (min === 0) {
            messageType = 'xe::validatorCheckedMax'
          }

          that.error($dst, that.$$xe.Lang.trans(messageType))
          return false
        }

        return true
      },
      required: function ($dst, parameters) {
        const value = that.getValue($dst)
        if (value === '') {
          let errorMessage = 'validation.required'

          if ($dst.is('input[type=checkbox]') || $dst.is('input[type=radio]')) {
            errorMessage = 'validation.required_check'
          } else if ($dst.is('input[type=select]')) {
            errorMessage = 'validation.required_select'
          }

          that.error($dst, that.$$xe.Lang.trans(errorMessage, { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      alpha: function ($dst, parameters) {
        const value = that.getValue($dst)
        if (!value) return

        const pattern = /[a-zA-Z]/

        if (!pattern.test(value)) {
          that.error($dst, that.$$xe.Lang.trans('validation.alpha', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      alphanum: function ($dst, parameters) {
        return that.evaluator.alpha_num($dst, parameters, true)
      },
      alpha_num: function ($dst, parameters, alias) {
        const value = that.getValue($dst)
        if (!value) return

        const pattern = /[^a-zA-Z0-9]/

        if (pattern.test(value) === true) {
          let langKey = 'validation.alpha_num'
          if (alias) langKey = 'validation.alphanum'

          that.error($dst, that.$$xe.Lang.trans(langKey, { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      alpha_dash: function ($dst, parameters) {
        const value = that.getValue($dst)
        if (!value) return

        const pattern = /[^a-zA-Z0-9\-_]/

        if (pattern.test(value)) {
          that.error($dst, that.$$xe.Lang.trans('validation.alpha_dash', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      array: function ($dst, parameters) {
        if (Array.isArray(that.getValue($dst))) {
          that.error($dst, that.$$xe.Lang.trans('validation.array', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      boolean: function ($dst, parameters) {
        const value = that.getValue($dst)
        if (!value) return

        if (['1', '0', 'true', 'false'].indexOf(String(value).toLowerCase()) === -1) {
          that.error($dst, that.$$xe.Lang.trans('validation.boolean', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      date: function ($dst, parameters) {
        const value = that.getValue($dst)
        if (!value) return

        if (!$$.strtotime(value)) {
          that.error($dst, that.$$xe.Lang.trans('validation.date', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      date_format: function ($dst, parameters) {
        const value = that.getValue($dst)
        if (!value) return

        if (!moment(value, parameters).isValid()) {
          that.error($dst, that.$$xe.Lang.trans('validation.date_format', {
            attribute: $dst.data('valid-name') || $dst.attr('name'),
            format: parameters
          }))
          return false
        }

        return true
      },
      digits: function ($dst, parameters) {
        const value = that.getValue($dst)
        if (!value) return

        const pattern = /[^0-9]/
        const size = parseInt(parameters)

        if (pattern.test(value) || $dst.val().toString().length !== size) {
          that.error($dst, that.$$xe.Lang.trans('validation.digits', {
            attribute: $dst.data('valid-name') || $dst.attr('name'),
            digits: $$.addCommas(size)
          }))
          return false
        }
        return true
      },
      digits_between: function ($dst, parameters) {
        const value = that.getValue($dst)
        if (!value) return

        const range = parameters.split(',')
        const size = value.toString().length

        if (range[0] > size && size < range[1]) {
          that.error($dst, that.$$xe.Lang.trans('validation.digits_between', {
            attribute: $dst.data('valid-name') || $dst.attr('name'),
            min: $$.addCommas(range[0]),
            max: $$.addCommas(range[1])
          }))
          return false
        }
        return true
      },
      filled: function ($dst, parameters) {
        if (that.getValue($dst) === '') {
          that.error($dst, that.$$xe.Lang.trans('validation.filled', { attribute: $dst.attr('name') }))
          return false
        }
        return true
      },
      integer: function ($dst) {
        var value = that.getValue($dst)

        if (typeof value !== 'number' || isNaN(value) || Math.floor(value) !== value || !$.isNumeric(value)) {
          that.error($dst, that.$$xe.Lang.trans('validation.integer', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }
        return true
      },
      ip: function ($dst) {
        const value = that.getValue($dst)
        if (!value) return

        const pattern = /^(1|2)?\d?\d([.](1|2)?\d?\d){3}$/

        if (!pattern.test(value)) {
          that.error($dst, that.$$xe.Lang.trans('validation.ip', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      mimes: function ($dst, parameters) {
        const value = that.getValue($dst)
        if (!value) return

        const exts = parameters.split(',')

        if (exts.indexOf(value.split('.').pop()) === -1) {
          that.error($dst, that.$$xe.Lang.trans('validation.mimes', {
            attribute: $dst.data('valid-name') || $dst.attr('name'),
            values: '[' + parameters + ']'
          }))
          return false
        }

        return true
      },
      // nullable: function ($dst) {
      //   var value = $dst.val()
      //
      //   if (value != null) {
      //     that.error($dst, that.$$xe.Lang.trans('validation.nullable'))
      //     return false
      //   }
      //
      //   return true
      // },
      regex: function ($dst, pattern) {
        const value = that.getValue($dst)
        if (!value) return

        if (!pattern.text(value)) {
          that.error($dst, that.$$xe.Lang.trans('validation.regex', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      json: function ($dst) {
        const value = that.getValue($dst)
        if (!value) return

        try {
          JSON.parse(value)
          return true
        } catch (e) {
          that.error($dst, that.$$xe.Lang.trans('validation.json', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }
      },
      string: function ($dst) {
        const value = that.getValue($dst)
        if (!value) return

        if (typeof value !== 'string') {
          that.error($dst, that.$$xe.Lang.trans('validation.string', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      min: function ($dst, parameters) {
        const value = that.getValue($dst)
        if (!value) return

        const type = $dst.data('valid-type')

        switch (type) {
          case 'numeric':
            if (parseInt(value) <= parseInt(parameters)) {
              that.error($dst, that.$$xe.Lang.trans('validation.min.numeric', {
                attribute: $dst.data('valid-name') || $dst.attr('name'),
                min: $$.addCommas(parameters)
              }))

              return false
            }

            break

          case 'file':
            if ($dst[0].files[0] && ($dst[0].files[0].size / 1024) <= parseInt(parameters)) {
              that.error($dst, that.$$xe.Lang.trans('validation.min.file', {
                attribute: $dst.data('valid-name') || $dst.attr('name'),
                min: $$.addCommas(parameters)
              }))

              return false
            }

            break

          case 'string':
            if (value.length <= parseInt(parameters)) {
              that.error($dst, that.$$xe.Lang.trans('validation.min.string', {
                attribute: $dst.data('valid-name') || $dst.attr('name'),
                min: $$.addCommas(parameters)
              }))

              return false
            }

            break

          default:
            if (value.length <= parseInt(parameters)) {
              that.error($dst, that.$$xe.Lang.transChoice('xe::validatorMin', parameters, { charCount: $$.addCommas(parameters) }))
              return false
            }
        }

        return true
      },
      max: function ($dst, parameters) {
        const value = that.getValue($dst)
        if (!value) return

        const type = $dst.data('valid-type')

        switch (type) {
          case 'numeric':
            if (parseInt(value) >= parseInt(parameters)) {
              that.error($dst, that.$$xe.Lang.trans('validation.max.numeric', {
                attribute: $dst.data('valid-name') || $dst.attr('name'),
                max: $$.addCommas(parameters)
              }))

              return false
            }

            break

          case 'file':
            if ($dst[0].files[0] && ($dst[0].files[0].size / 1024) >= parseInt(parameters)) {
              that.error($dst, that.$$xe.Lang.trans('validation.max.file', {
                attribute: $dst.data('valid-name') || $dst.attr('name'),
                max: $$.addCommas(parameters)
              }))

              return false
            }

            break

          case 'string':
            if (value.length >= parseInt(parameters)) {
              that.error($dst, that.$$xe.Lang.trans('validation.max.string', {
                attribute: $dst.data('valid-name') || $dst.attr('name'),
                max: $$.addCommas(parameters)
              }))

              return false
            }

            break
        }

        return true
      },
      email: function ($dst, parameters) {
        const value = that.getValue($dst)
        if (!value) return

        const pattern = /(^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$)/

        if (!value.match(pattern)) {
          that.error($dst, that.$$xe.Lang.trans('validation.email', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      url: function ($dst, parameters) {
        const value = that.getValue($dst)
        if (!value) return

        const pattern = /^https?:\/\/\S+/

        if (!value.match(pattern)) {
          that.error($dst, that.$$xe.Lang.trans('validation.url', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      numeric: function ($dst, parameters) {
        const value = that.getValue($dst)
        if (!value) return

        const num = Number(value)

        if (typeof num === 'number' && !isNaN(num) && typeof val !== 'boolean') {
          return true
        } else {
          that.error($dst, that.$$xe.Lang.trans('validation.numeric', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }
      },
      between: function ($dst, parameters) {
        const value = that.getValue($dst)
        if (!value) return

        const range = parameters.split(',')
        const type = $dst.data('valid-type')

        switch (type) {
          case 'numeric':
            if (!$.isNumeric(value) || parseInt(value) < parseInt(range[0]) || parseInt(value) > parseInt(range[1])) {
              that.error($dst, that.$$xe.Lang.trans('validation.between.numeric', {
                attribute: $dst.data('valid-name') || $dst.attr('name'),
                min: $$.addCommas(range[0]),
                max: $$.addCommas(range[1])
              }))

              return false
            }

            break

          case 'file':
            if ($dst[0].files[0] && ((($dst[0].files[0].size / 1024) < range[0]) || (($dst[0].files[0].size / 1024) > range[1]))) {
              that.error($dst, that.$$xe.Lang.trans('validation.between.file', {
                attribute: $dst.data('valid-name') || $dst.attr('name'),
                min: $$.addCommas(range[0]),
                max: $$.addCommas(range[1])
              }))

              return false
            }

            break

          case 'string':
            if (value.length < range[0] || value.length > range[1]) {
              that.error($dst, that.$$xe.Lang.trans('validation.between.string', {
                attribute: $dst.data('valid-name') || $dst.attr('name'),
                min: $$.addCommas(range[0]),
                max: $$.addCommas(range[1])
              }))

              return false
            }

            break

          default:
            if (value.length <= parseInt(range[0]) || value.length >= parseInt(range[1])) {
              that.error($dst, that.$$xe.Lang.trans('xe::validatorBetween', {
                attribute: $dst.data('valid-name') || $dst.attr('name'),
                min: $$.addCommas(range[0]),
                max: $$.addCommas(range[1])
              }))
              return false
            }
        }
      }
    }
  }

  static appName () {
    return 'Validator'
  }

  boot (XE, config) {
    if (this.booted()) {
      return Promise.resolve(this)
    }

    return new Promise((resolve) => {
      super.boot(XE)
      const that = this

      this.locale = this.$$config.getters['lang/current'].code

      $(() => {
        $('form[data-rule]').each(function () {
          const rule = that.$$config.getters['validator/rule']($(this).data('rule'))
          const $form = $(this)
          if (rule) {
            that.setRules(rule.ruleName, rule.rules)
          }
          getForm($form).$$on('submit', function (eventName, { element, event }) {
            event.preventDefault()
            try {
              const check = that.check($(element))
              check.then(() => {
                this.submit()
                return Promise.resolve()
              }, () => {})
            } catch (e) {
              event.preventDefault()
              return Promise.reject(e)
            }

            return Promise.resolve()
          }, { name: 'xe.validator' })
        })
      })

      this.registerPlugin(new PluginMarker())

      resolve(this)
    })
  }

  /**
  * @deprecated
  * @ignore
  */
  init (ruleName) { }

  /**
  * 룰을 세팅한다.
  * @param {string} ruleName
  * @param {object} rules
  */
  setRules (ruleName, rules) {
    let lang = []
    let langMap = {}

    $.each(rules, function (k, v) {
      let ruleList = v.split('|')

      $.each(ruleList, function (idx, val) {
        let langKey = val.split(':')[0].toLowerCase()

        if (langKey === 'langrequired') {
          langKey = 'required'
        }

        if (!Translator.hasMessage('validation.' + langKey) && !langMap.hasOwnProperty(langKey)) {
          langMap[langKey] = ''

          if (['min', 'max', 'between'].indexOf(langKey) !== -1) {
            lang.push('validation.' + langKey + '.numeric')
            lang.push('validation.' + langKey + '.string')
            lang.push('validation.' + langKey + '.file')
          } else {
            lang.push('validation.' + langKey)
          }

          lang.push('validation.required_check')
          lang.push('validation.required_select')
        }
      })
    })

    if (lang.length > 0) {
      this.$$xe.Lang.requestTransAll(lang)
    }

    if (this.rules[ruleName] !== undefined) {
      if (!originalRules[ruleName]) {
        originalRules[ruleName] = Object.assign({}, this.rules[ruleName])
      }

      this.rules[ruleName] = Object.assign({}, this.rules[ruleName], rules)

      /*
      * eventName
      * ruleName
      * rules : 누적
      * additional : 새로 추가된 룰
      * origin : 처음 설정된 룰
      * reassign : 룰을 다시 설정
      */
      this.$$emit('setRules', ruleName, this.rules[ruleName], rules, originalRules[ruleName], (rules) => {
        this.rules[ruleName] = rules
      })
    } else {
      this.rules[ruleName] = rules
    }
  }

  /**
  * 폼요소의 룰명을 리턴한다.
  * @param {jQuery} $form jQuery form element
  * @return {string}
  */
  getRuleName ($form) {
    return $form.data('rule')
  }

  /**
  * 대상 폼 안의 fields 반환.
  * jQuery의 특성을 이용해 field가 나타나는 순서대로 정렬된다.
  *
  * @param {jQuery} $form jQuery form element
  */
  getTargetElements ($form) {
    if (!$($form).is('form')) return

    const ruleName = this.getRuleName($form)
    const rules = this.rules[ruleName]

    const selector = []
    Object.entries(rules).forEach((item) => {
      selector.push(`[name=${item[0]}]`)
    })

    return $(selector.join(','))
  }

  /**
  * 폼에 정의 된 룰을 실행한다.
  * @param {jQuery} $form jQuery form element
  */
  check ($form) {
    if (!$($form).is('form')) return

    const that = this
    const ruleName = this.getRuleName($form)
    const rules = this.rules[ruleName]
    const elements = this.getTargetElements($form)
    const result = []

    that.errorClear($form)

    elements.each(function () {
      const name = $(this).attr('name')
      const rule = rules[name]
      const ddd = that.validate($form, $(this).attr('name'), rule)
      ddd.then(() => {}).catch((e) => {
        const form = getForm($form)
        form.$$emit('xe.validation.faield', { field: e.field }) // @DEPRECATED 오타. 3.1.0 제거 예정
        form.$$emit('xe.validation.failed', { field: e.field })
      })
      result.push(ddd)
    })

    Promise.all(result)
      .then(() => {
      })
      .catch((e) => {
        $form.data('valid-result', false)
        const form = getForm($form)
        form.$$emit('xe.validation.failed', { field: e.filed }) // @DEPRECATED 오타. 3.1.0 제거 예정
        form.$$emit('xe.validation.failed', { field: e.field })
      })

    return Promise.all(result)
  }

  /**
  * 폼에 정의 된 룰을 실행한다.
  * @param {jQuery} $form jQuery form element
  * @deprecated
  */
  checkRuleContainers ($form) {
    let that = this
    let containers = $form.find('[data-rule]')

    $.each(containers, function (index, container) {
      let ruleName = $(container).data('rule')
      let rules = that.rules[ruleName]

      $.each(rules, function (name, rule) {
        that.validate($form, name, rule)
      })
    })
  }

  /**
  * 폼안의 요소에 정의된 룰을 실행한다.
  * @param {jQuery} $form jQuery form element
  * @deprecated
  */
  formValidate ($form) {
    let that = this

    that.errorClear($form)

    $form.find('[data-valid]').each(function () {
      let $this = $(this)
      let rule = $this.data('valid')
      let name = $this.attr('name')

      that.validate($form, name, rule)
    })
  }

  /**
  * 폼 내의 name요소에 대한 rule을 실행한다.
  * @param {jQuery} $form jQuery form element
  * @param {string} name
  * @param {string} rule
  * @throws {ValidationError} validation 실패시
  */
  validate ($form, name, rule) {
    const validateResult = []
    let parts = rule.split('|')
    let that = this

    $form.data('valid-result', true)

    $.each(parts, function (index, part) {
      const [evaluatorName, options] = part.split(':')

      if (typeof that.evaluator[evaluatorName] === 'function') {
        // that.errorClear($form)
        const $field = $form.find(`[name="${name}"]`)
        const result = that.evaluator[evaluatorName]($field, options)

        if (result instanceof Promise) {
          validateResult.push(new Promise((resolve, reject) => {
            result.then(res => {
              if (res === false || (res && res.valid === false)) {
                $form.data('valid-result', false)
                reject(new ValidationError('Validation error.', $field))
              } else {
                resolve()
              }
            }).catch(() => {})
          }))
        } else if (result === false || (result && result.valid === false)) {
          $form.data('valid-result', false)
          validateResult.push(Promise.reject(new ValidationError('Validation error.', $field)))
        }
      }
    })

    // validateResult.then(() => {}).catch((e) => {})

    return Promise.all(validateResult)
  }

  /**
  * alert type을 확장
  * @param {string} type 이름
  * @param {function} callback
  */
  extendAlertType (type, callback) {
    this.alertTypes[type] = callback
  }

  /**
  * 정의된 항목 중 지정된 alert type을 반환
  * @param {string} type 이름
  */
  getAlertType (type) {
    return this.alertTypes[type] || null
  }

  /**
  * evaluator 추가
  * @deprecated
  * @param {string} name evaluator name
  * @param {function} callback validation 실패시 호출
  */
  put (name, callback) {
    this.putEvaluator(name, callback)
  }

  /**
  * evaluator 추가
  * @param {string} name evaluator name
  * @param {function} callback validation 실패시 호출
  */
  putEvaluator (name, callback) {
    this.evaluator[name] = callback
  }

  /**
  * evaluator 존재 확인
  * @param {string} name evaluator name
  * @return {boolean}
  */
  hasEvaluator (name) {
    return !!this.evaluator[name]
  }

  /**
  * evaluator 반환
  * @param {string} name evaluator name
  * @return {mixed}
  */
  getEvaluator (name) {
    return this.evaluator[name] || null
  }

  /**
  * validation 메시지 제거
  * @param {jQuery} $form jQuery form element
  */
  errorClear ($form) {
    this.$$xe.Griper.form.fn.clear($form)
  }

  /**
  * validation 실패 메시지를 노출한다.
  * @param {jQuery} $element
  * @param {string} message
  * @param {object} replaceStrMap
  */
  error ($element, message, replaceStrMap) {
    const inlineMessage = $element.data('valid-message-' + this.locale) || $element.data('valid-message')
    const alertType = $element.closest('form').data('rule-alert-type') || 'form'
    if (inlineMessage) {
      message = inlineMessage
    }

    if (replaceStrMap && Object.keys(replaceStrMap).length > 0) {
      $.each(replaceStrMap, function (key, val) {
        message = message.replace(':' + key, val)
      })
    }

    if (typeof this.alertTypes[alertType] === 'function') {
      this.alertTypes[alertType]($element, message)
    } else if (alertType === 'form') {
      this.$$xe.Griper.form($element, message)
    } else if (alertType === 'toast') {
      this.$$xe.Griper.toast('danger', message)
    }
  }

  /**
  * validation 엘리먼트 요소의 value를 리턴한다.
  * @param {jQuery} $ele
  * @return {string}
  */
  getValue ($ele) {
    let value = ''

    if ($ele[0].tagName === 'SELECT') {
      value = $ele.find('option:selected').val()
    } else if ($ele.is('input[type=checkbox]') || $ele.is('input[type=radio]')) {
      if ($ele.is(':checked')) {
        value = $ele.filter(':checked').val()
      }
    } else {
      value = $ele.val()
    }

    return value
  }
}

export default Validator
