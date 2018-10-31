import _get from 'lodash/get'
import _initial from 'lodash/initial'
import _isFunction from 'lodash/isFunction'
import $ from 'jquery'

/* global FormData */

export default function bindAjaxForm (formEntity) {
  formEntity.$$on('submit', (eventName, { element, preventSubmit }) => {
    const $element = $(element)
    if ($element.is('[data-submit=xe-ajax]')) {
      preventSubmit()
      ajaxSend({ $element, element })
    }
  })
}

function ajaxSend ({ $element, element }) {
  // preventSubmit()
  const callback = $element.data('callback') || ''
  const validate = !!$element.data('validate')

  const callbackObj = _initial(window, callback)
  const callbackFunc = _get(window, callback)

  const formData = new FormData(element)
  const options = {
    url: $element.attr('action'),
    method: $element.attr('method'),
    data: formData,
    dataType: 'json',
    contentType: false,
    processData: false
  }

  if (_isFunction(callbackFunc)) {
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
