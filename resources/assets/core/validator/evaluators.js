import griper from 'xe-common/griper' // @FIXME https://github.com/xpressengine/xpressengine/issues/765
import moment from 'moment'
import Translator from 'xe-common/translator' // @FIXME https://github.com/xpressengine/xpressengine/issues/765
import * as $$ from 'xe/utils'
import Lang from 'xe/lang' // @FIXME https://github.com/xpressengine/xpressengine/issues/765
import $ from 'jquery'
import Plugin from 'xe/plugin'

export default class DefaultEvaluator extends Plugin {
  constructor () {
    super()

    this.evaluators = {
      accepted: function ($dst, parameters) {
        const value = this.$app.getValue($dst)
        if (!value) return

        if (['yes', 'ok', 'accept', 'accepted', 'on', '1', 'true'].indexOf(String(value).toLowerCase()) === -1) {
          this.$app.error($dst, Lang.instance.trans('validation.accepted', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
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

          this.$app.error($dst, Lang.instance.trans(messageType))
          return false
        }

        return true
      },
      required: function ($dst, parameters) {
        const value = this.$app.getValue($dst)

        if (value === '') {
          this.$app.error($dst, Lang.instance.trans('validation.required', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      alpha: function ($dst, parameters) {
        const value = this.$app.getValue($dst)
        if (!value) return

        const pattern = /[a-zA-Z]/

        if (!pattern.test(value)) {
          this.$app.error($dst, Lang.instance.trans('validation.alpha', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      alphanum: function ($dst, parameters) {
        return this.$app.evaluator.alpha_num($dst, parameters, true)
      },
      alpha_num: function ($dst, parameters, alias) {
        const value = this.$app.getValue($dst)
        if (!value) return

        const pattern = /[^a-zA-Z0-9]/

        if (pattern.test(value) === true) {
          let langKey = 'validation.alpha_num'
          if (alias) langKey = 'validation.alphanum'

          this.$app.error($dst, Lang.instance.trans(langKey, { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      alpha_dash: function ($dst, parameters) {
        const value = this.$app.getValue($dst)
        if (!value) return

        const pattern = /[^a-zA-Z0-9\-_]/

        if (pattern.test(value)) {
          this.$app.error($dst, Lang.instance.trans('validation.alpha_dash', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      array: function ($dst, parameters) {
        if (Array.isArray(this.$app.getValue($dst))) {
          this.$app.error($dst, Lang.instance.trans('validation.array', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      boolean: function ($dst, parameters) {
        const value = this.$app.getValue($dst)
        if (!value) return

        if (['1', '0', 'true', 'false'].indexOf(String(value).toLowerCase()) === -1) {
          this.$app.error($dst, Lang.instance.trans('validation.boolean', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      date: function ($dst, parameters) {
        const value = this.$app.getValue($dst)
        if (!value) return

        if (!$$.strtotime(value)) {
          this.$app.error($dst, Lang.instance.trans('validation.date', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      date_format: function ($dst, parameters) {
        const value = this.$app.getValue($dst)
        if (!value) return

        if (!moment(value, parameters).isValid()) {
          this.$app.error($dst, Lang.instance.trans('validation.date_format', {
            attribute: $dst.data('valid-name') || $dst.attr('name'),
            format: parameters
          }))
          return false
        }

        return true
      },
      digits: function ($dst, parameters) {
        const value = this.$app.getValue($dst)
        if (!value) return

        const pattern = /[^0-9]/
        const size = parseInt(parameters)

        if (pattern.test(value) || $dst.val().toString().length !== size) {
          this.$app.error($dst, Lang.instance.trans('validation.digits', {
            attribute: $dst.data('valid-name') || $dst.attr('name'),
            digits: $$.addCommas(size)
          }))
          return false
        }
        return true
      },
      digits_between: function ($dst, parameters) {
        const value = this.$app.getValue($dst)
        if (!value) return

        const range = parameters.split(',')
        const size = value.toString().length

        if (range[0] > size && size < range[1]) {
          this.$app.error($dst, Lang.instance.trans('validation.digits_between', {
            attribute: $dst.data('valid-name') || $dst.attr('name'),
            min: $$.addCommas(range[0]),
            max: $$.addCommas(range[1])
          }))
          return false
        }
        return true
      },
      filled: function ($dst, parameters) {
        if (this.$app.getValue($dst) === '') {
          this.$app.error($dst, Lang.instance.trans('validation.filled', { attribute: $dst.attr('name') }))
          return false
        }
        return true
      },
      integer: function ($dst) {
        var value = this.$app.getValue($dst)

        if (typeof value !== 'number' || isNaN(value) || Math.floor(value) !== value || !$.isNumeric(value)) {
          this.$app.error($dst, Lang.instance.trans('validation.integer', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }
        return true
      },
      ip: function ($dst) {
        const value = this.$app.getValue($dst)
        if (!value) return

        const pattern = /^(1|2)?\d?\d([.](1|2)?\d?\d){3}$/

        if (!pattern.test(value)) {
          this.$app.error($dst, Lang.instance.trans('validation.ip', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      mimes: function ($dst, parameters) {
        const value = this.$app.getValue($dst)
        if (!value) return

        const exts = parameters.split(',')

        if (exts.indexOf(value.split('.').pop()) === -1) {
          this.$app.error($dst, Lang.instance.trans('validation.mimes', {
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
      //     this.$app.error($dst, Lang.instance.trans('validation.nullable'))
      //     return false
      //   }
      //
      //   return true
      // },
      regex: function ($dst, pattern) {
        const value = this.$app.getValue($dst)
        if (!value) return

        if (!pattern.text(value)) {
          this.$app.error($dst, Lang.instance.trans('validation.regex', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      json: function ($dst) {
        const value = this.$app.getValue($dst)
        if (!value) return

        try {
          JSON.parse(value)
          return true
        } catch (e) {
          this.$app.error($dst, Lang.instance.trans('validation.json', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }
      },
      string: function ($dst) {
        const value = this.$app.getValue($dst)
        if (!value) return

        if (typeof value !== 'string') {
          this.$app.error($dst, Lang.instance.trans('validation.string', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      min: function ($dst, parameters) {
        const value = this.$app.getValue($dst)
        if (!value) return

        const type = $dst.data('valid-type')

        switch (type) {
          case 'numeric':
            if (parseInt(value) <= parseInt(parameters)) {
              this.$app.error($dst, Lang.instance.trans('validation.min.numeric', {
                attribute: $dst.data('valid-name') || $dst.attr('name'),
                min: $$.addCommas(parameters)
              }))

              return false
            }

            break

          case 'file':
            if ($dst[0].files[0] && ($dst[0].files[0].size / 1024) <= parseInt(parameters)) {
              this.$app.error($dst, Lang.instance.trans('validation.min.file', {
                attribute: $dst.data('valid-name') || $dst.attr('name'),
                min: $$.addCommas(parameters)
              }))

              return false
            }

            break

          case 'string':
            if (value.length <= parseInt(parameters)) {
              this.$app.error($dst, Lang.instance.trans('validation.min.string', {
                attribute: $dst.data('valid-name') || $dst.attr('name'),
                min: $$.addCommas(parameters)
              }))

              return false
            }

            break

          default:
            if (value.length <= parseInt(parameters)) {
              this.$app.error($dst, Lang.instance.transChoice('xe::validatorMin', parameters, { charCount: $$.addCommas(parameters) }))
              return false
            }
        }

        return true
      },
      max: function ($dst, parameters) {
        const value = this.$app.getValue($dst)
        if (!value) return

        const type = $dst.data('valid-type')

        switch (type) {
          case 'numeric':
            if (parseInt(value) >= parseInt(parameters)) {
              this.$app.error($dst, Lang.instance.trans('validation.max.numeric', {
                attribute: $dst.data('valid-name') || $dst.attr('name'),
                max: $$.addCommas(parameters)
              }))

              return false
            }

            break

          case 'file':
            if ($dst[0].files[0] && ($dst[0].files[0].size / 1024) >= parseInt(parameters)) {
              this.$app.error($dst, Lang.instance.trans('validation.max.file', {
                attribute: $dst.data('valid-name') || $dst.attr('name'),
                max: $$.addCommas(parameters)
              }))

              return false
            }

            break

          case 'string':
            if (value.length >= parseInt(parameters)) {
              this.$app.error($dst, Lang.instance.trans('validation.max.string', {
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
        const value = this.$app.getValue($dst)
        if (!value) return

        const pattern = /\w+@\w{2,}\.\w{2,}/

        if (!value.match(pattern)) {
          this.$app.error($dst, Lang.instance.trans('validation.email', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      url: function ($dst, parameters) {
        const value = this.$app.getValue($dst)
        if (!value) return

        const pattern = /^https?:\/\/\S+/

        if (!value.match(pattern)) {
          this.$app.error($dst, Lang.instance.trans('validation.url', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }

        return true
      },
      numeric: function ($dst, parameters) {
        const value = this.$app.getValue($dst)
        if (!value) return

        const num = Number(value)

        if (typeof num === 'number' && !isNaN(num) && typeof val !== 'boolean') {
          return true
        } else {
          this.$app.error($dst, Lang.instance.trans('validation.numeric', { attribute: $dst.data('valid-name') || $dst.attr('name') }))
          return false
        }
      },
      between: function ($dst, parameters) {
        const value = this.$app.getValue($dst)
        if (!value) return

        const range = parameters.split(',')
        const type = $dst.data('valid-type')

        switch (type) {
          case 'numeric':
            if (!$.isNumeric(value) || parseInt(value) < parseInt(range[0]) || parseInt(value) > parseInt(range[1])) {
              this.$app.error($dst, Lang.instance.trans('validation.between.numeric', {
                attribute: $dst.data('valid-name') || $dst.attr('name'),
                min: $$.addCommas(range[0]),
                max: $$.addCommas(range[1])
              }))

              return false
            }

            break

          case 'file':
            if ($dst[0].files[0] && ((($dst[0].files[0].size / 1024) < range[0]) || (($dst[0].files[0].size / 1024) > range[1]))) {
              this.$app.error($dst, Lang.instance.trans('validation.between.file', {
                attribute: $dst.data('valid-name') || $dst.attr('name'),
                min: $$.addCommas(range[0]),
                max: $$.addCommas(range[1])
              }))

              return false
            }

            break

          case 'string':
            if (value.length < range[0] || value.length > range[1]) {
              this.$app.error($dst, Lang.instance.trans('validation.between.string', {
                attribute: $dst.data('valid-name') || $dst.attr('name'),
                min: $$.addCommas(range[0]),
                max: $$.addCommas(range[1])
              }))

              return false
            }

            break

          default:
            if (value.length <= parseInt(range[0]) || value.length >= parseInt(range[1])) {
              this.$app.error($dst, Lang.instance.trans('xe::validatorBetween', { between: parameters }))
              return false
            }
        }
      }
    }
  }

  get name () {
    return 'DefaultEvaluator'
  }

  boot (XE, App) {
    super.boot(XE, App)

    this.evaluators.forEach((evaluator, name) => {
      App.evaluators.set(name, evaluator)
    })
  }
}
