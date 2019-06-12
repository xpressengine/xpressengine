import _ from 'lodash'
import $ from 'jquery'

/* global FormData */

export default function bindAjaxForm (formEntity) {
  if (formEntity.$element.is('[data-submit=xe-ajax]')) {
    formEntity.$$on('submit', (eventName, { element, preventSubmit }) => {
      const $element = $(element)
      preventSubmit()
      ajaxSend({ $element, element })
      return Promise.resolve({ stop: true })
    }, { name: 'xe.form.ajax' })
  }
}

function ajaxSend ({ $element, element }) {
  // preventSubmit()
  const callback = $element.data('callback') || ''
  const validate = !!$element.data('validate')

  const callbackObj = _.initial(window, callback)
  const callbackFunc = _.get(window, callback)

  const formData = new FormData(element)
  const options = {
    url: $element.attr('action'),
    method: $element.attr('method'),
    data: formData,
    dataType: 'json',
    contentType: false,
    processData: false
  }

  if (_.isFunction(callbackFunc)) {
    options.success = function (data, textStatus, jqXHR) {
      callbackFunc.call(callbackObj, data, textStatus, jqXHR)
    }
  }

  // @FIXME
  if (isValidForm(options)) {
    if (validate === true) {
      window.XE.formValidate($element)
    }

    window.XE.ajax(options)
  }
}

function isValidForm (options) {
  if (!options.url) {
    console.error('form action값이 없음')
    return false
  }

  if (!options.method) {
    console.error('form method값이 없음')
    return false
  }

  return true
}
