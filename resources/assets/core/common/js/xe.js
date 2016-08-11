(function(exports) {
  'use strict';

  var self;

  /**
   * @description
   * <pre>
   *     XE module initialize
   * </pre>
   * */
  function initialize() {
    self = this;

    return this;
  }


  function ajax(url, options) {
    if ( typeof url === "object" ) {
      options = $.extend({}, self.Request.options, url);
      url = undefined;
    } else {
      options = $.extend({}, options, self.Request.options, {url: url});
      url = undefined;
    }

    return $.ajax(url, options);
  }

  /**
   * @param {object} options
   * */
  function setup(options) {
    self.options.loginUserId = options.loginUserId;
    self.Request.setup({
      headers: {
        'X-CSRF-TOKEN': options['X-CSRF-TOKEN']
      }
    });

  }

  /**
   * @param {object} options
   * */
  function configure(options) {
    $.extend(self.options, options);
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

  function validate($form) {
    System.import('xecore:/common/js/validator').then(function (validator) {
      validator.validate($form);
    });
  }

  function getLocale() {
    return self.options.locale;
  }

  function getDefaultLocale() {
    return self.options.defaultLocale;
  }


  // $.ajaxPrefilter(function(options, originalOptions, jqXHR ) {
  //   $.extend(options, self.Request.options);
  // });


  exports.XE = function() {
    return {
      initialize: initialize,
      ajax: ajax,
      setup: setup,
      configure: configure,
      cssLoad: cssLoad,
      jsLoad: jsLoad,
      toast: toast,
      toastByStatus: toastByStatus,
      formError: formError,
      formErrorClear: formErrorClear,
      validate: validate,
      getLocale: getLocale,
      getDefaultLocale: getDefaultLocale,

      options: {},

      Lang: '',
      Progress: '',
      Request: '',
      Component: ''
    }.initialize();
  }();

})(window);