(function(exports) {
  'use strict';

  var self,
      _options;


  var XE = {
    initialize: initialize,
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
  };

  exports.XE = XE;

  return XE;

  /**
   * @description
   * <pre>
   *     XE module initialize
   * </pre>
   * */
  function initialize(callback) {

    self = this;
    _options = {};

    _loadXEModule().promise().then(function() {
      callback();
    });

  }


  function _loadXEModule() {

    var d = $.Deferred();
    System.amdRequire(['xe.lang', 'xe.progress', 'xe.request', 'xe.component'], function(lang, progress, request, component) {

      self.Lang = lang;
      self.Progress = progress;
      self.Request = request;
      self.Component = component;

      self.ajax = self.Request.ajax = function(url, options) {
        if ( typeof url === "object" ) {
          options = $.extend({}, self.Request.options, url);
          url = undefined;
        } else {
          options = $.extend({}, options, self.Request.options, {url: url});
          url = undefined;
        }

        return $.ajax(url, options);
      };

      d.resolve();
    });

    return d;
  }

  /**
   * @param {object} options
   * */
  function setup(options) {
    _options.loginUserId = options.loginUserId;
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
    $.extend(_options, options);
    $.extend(self.options, options);
  }

  // @DEPRECATED
  function cssLoad(url, load, error) {
    var $css = $('<link>', {rel: 'stylesheet', type: 'text/css', href: url}).load(load).error(error);

    $('head').append($css);
  }

  function jsLoad(url, load, error) {
    var $js = $('<script>', {id: 'jsload', type: 'text/javascript', src: url});

    $js[0].addEventListener('load', load, true);

    $('head').append($js);
  }

  function toast(type, message) {
    if (type == '') {
      type = 'danger';
    }
    System.import('xecore:/common/js/modules/griper/griper').then(function (griper) {
      return griper.toast(type, message);
    });
  }

  function toastByStatus(status, message) {
    System.import('xecore:/common/js/modules/griper/griper').then(function (griper) {
      return griper.toast(griper.toast.fn.statusToType(status), message);
    });
  }

  function formError($element, message) {
    System.import('xecore:/common/js/modules/griper/griper').then(function (griper) {
      return griper.form($element, message);
    });
  }

  function formErrorClear($form) {
    System.import('xecore:/common/js/modules/griper/griper').then(function (griper) {
      return griper.form.fn.clear($form);
    });
  }

  function validate($form) {
    System.import('xecore:/common/js/modules/validator').then(function (validator) {
      validator.validate($form);
    });
  }

  function getLocale() {
    return _options.locale;
  }

  function getDefaultLocale() {
    return _options.defaultLocale;
  }

  if(this.Request) {

  }

  // $.ajaxPrefilter(function(options, originalOptions, jqXHR ) {
  //   $.extend(options, self.Request.options);
  // });


})(window);