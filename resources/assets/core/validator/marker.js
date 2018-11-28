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
              let field

              if (ruleList.includes('lang_required')) {
                field = $(`[data-name=${k}]`, container)
                label = field.siblings('label')
              } else {
                field = $(`[name=${k}]`, container)
                label = field.siblings('label')
                if (!label.langth) {
                  label = field.closest('.__xe-input-group, .form-group').find('label')
                }
              }

              if (label.length === 1) {
                label.addClass('xe-form__label--requried')
                form.$$emit('xe.valitation.required-label', { field, label })
              } else {
                form.$$emit('xe.valitation.required-label.notfound', { field })
              }
            }
          })
        })
      })
    })
  }
}
