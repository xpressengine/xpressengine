import $ from 'jquery'
import Progress from 'xe-common/progress' // @FIXME https://github.com/xpressengine/xpressengine/issues/765

/**
 * @module Request
 **/
export default (function () {
  /** @private */
  var that

  /** @private */
  var _options = {
    headers: {
      'X-CSRF-TOKEN': null
    }
  }

  // @FIXME
  $(document).ajaxSend(function (event, jqxhr, settings) {
    if (settings.useXeSpinner) {
      Progress.start(settings.context == undefined ? $('body') : settings.context)
    }
  }).ajaxComplete(function (event, jqxhr, settings) {
    if (settings.useXeSpinner) {
      Progress.done(settings.context == undefined ? $('body') : settings.context)
    }
  }).ajaxError(function (event, jqxhr, settings, thrownError) {
    if (settings.useXeSpinner) {
      Progress.done()
    }

    if (!settings.hasOwnProperty('error')) {
      that.error(jqxhr, settings, thrownError)
    }
  })

  return {
    /**
     * Request module 초기화한다.
     * @method
     * @return this
     **/
    init: function () {
      that = this
      return this
    },

    /**
     * @public
     **/
    options: _options,
    /**
     * ajax 옵션을 세팅한다.
     * @param {object} options jQuery ajax options
     **/
    setup: function (options) {
      $.extend(_options, options)
    },

    /**
     * ajax를 method get 방식으로 호출한다.
     * @param {string} url
     * @param {object} data
     * @param {function} success
     * @param {string} dataType
     **/
    get: function (url, data, success, dataType) {
      let settings = $.extend({}, this.options, {
        method: 'GET',
        url,
        data,
        success,
        dataType
      })

      return $.ajax(settings)
    },

    /**
     * ajax를 method post 방식으로 호출한다.
     * @param {string} url
     * @param {object} data
     * @param {function} success
     * @param {string} dataType
     **/
    post: function (url, data, success, dataType) {
      let settings = $.extend({}, this.options, {
        method: 'POST',
        url,
        data,
        success,
        dataType
      })

      return $.ajax(settings)
    },

    /**
     * ajax 오류 메시지를 노출한다.
     * @param {object} jqxhr
     * @param {object} settings
     * @params {object} thrownError
     **/
    error: function (jqxhr, settings, thrownError) {
      var status = jqxhr.status
      var errorMessage = 'Not defined error message (' + status + ')'

      // @TODO dataType 에 따라 메시지 획득 방식을 추가 해야함.
      if (jqxhr.status == 422) {
        var list = $.parseJSON(jqxhr.responseText).errors || {}

        errorMessage = ''
        errorMessage += '<ul>'
        for (var i in list) {
          errorMessage += '<li>' + list[i] + '</li>'
        }

        errorMessage += '</ul>'
      } else if (settings.dataType == 'json') {
        errorMessage = $.parseJSON(jqxhr.responseText).message
      } else {
        errorMessage = jqxhr.statusText
      }

      // @FIXME 의존성
      window.XE.toastByStatus(status, errorMessage)
    }
  }.init()
})()
