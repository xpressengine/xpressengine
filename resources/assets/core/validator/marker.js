import Plugin from 'xe/plugin'
import $ from 'jquery'

export default class RequiredMarker extends Plugin {
  constructor () {
    super()
  }

  get name () {
    return 'RequiredMarker'
  }

  boot (XE, App) {
    super.boot(XE, App)

    $(() => {
      $('form[data-rule]').each(function () {
        XE.app('Form').then((appForm) => {
          const form = appForm.get(this)
          const rule = App.$$config.getters['validator/rule'](form.$element.data('rule'))

          $.each(rule.rules, function (k, v) {
            let ruleList = v.split('|')
            if (ruleList.includes('required') || ruleList.includes('lang_required')) {
              let container = form.$element
              let label
              if (ruleList.includes('lang_required')) {
                label = $(`[data-name=${k}]`, container).siblings('label')
              } else {
                label = $(`[name=${k}]`, container).siblings('label')
              }

              if (label.length === 1) {
                label.addClass('xe-form__label--requried')
              }
            }
          })
        })
      })
    })
  }
}
