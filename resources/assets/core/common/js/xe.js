var XE = (function (exports) {
  'use strict';

  var _this = this;

  function ajax(url, options) {
    if (typeof url === 'object') {
      options = $.extend({}, _this.Request.options, url);
      url = undefined;
    } else {
      options = $.extend({}, options, _this.Request.options, { url: url });
      url = undefined;
    }

    return $.ajax(url, options);
  }

  /**
    * @param {object} options
    * */
  function setup(options) {
    _this.options.loginUserId = options.loginUserId;
    _this.Request.setup({
      headers: {
        'X-CSRF-TOKEN': options['X-CSRF-TOKEN'],
      },
    });

  }

  /**
    * @param {object} options
    * */
  function configure(options) {
    $.extend(_this.options, options);
  }

  // @DEPRECATED
  function cssLoad(url) {
    DynamicLoadManager.cssLoad(url);
  }

  function jsLoad(url) {
    DynamicLoadManager.jsLoad(url);
  }

  function toast(type, message) {
    if (type == '') {
      type = 'danger';
    }

    System.import('xecore:/common/js/griper').then(function (griper) {
      return griper.toast(type, message);
    });
  }

  function toastByStatus(status, message) {
    System.import('xecore:/common/js/griper').then(function (griper) {
      return griper.toast(griper.toast.fn.statusToType(status), message);
    });
  }

  function formError($element, message) {
    System.import('xecore:/common/js/griper').then(function (griper) {
      return griper.form($element, message);
    });
  }

  function formErrorClear($form) {
    System.import('xecore:/common/js/griper').then(function (griper) {
      return griper.form.fn.clear($form);
    });
  }

  function formValidate($form) {
    System.import('xecore:/common/js/validator').then(function (validator) {
      validator.formValidate($form);
    });
  }

  function getLocale() {
    return _this.options.locale;
  }

  function getDefaultLocale() {
    return _this.options.defaultLocale;
  }

  return {
    ajax: ajax,
    setup: setup,
    configure: configure,
    cssLoad: cssLoad,
    jsLoad: jsLoad,
    toast: toast,
    toastByStatus: toastByStatus,
    formError: formError,
    formErrorClear: formErrorClear,
    formValidate: formValidate,
    getLocale: getLocale,
    getDefaultLocale: getDefaultLocale,

    options: {},

    Lang: '',
    Progress: '',
    Request: '',
    Component: '',
  };
})(window);
