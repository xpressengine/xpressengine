(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    define([
      'exports',
      'jquery',
      'xecore:/common/js/xe.lang',
      'xecore:/common/js/xe.progress',
      'xecore:/common/js/xe.request',
      ], function (exports, $, XeLang, XeProgress, XeRequest) {
        root.XE = exports
        factory((root.XE = exports), $, XeLang, XeProgress, XeRequest);
      });
  } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
    factory(exports, require('jquery'), require('xecore:/common/js/xe.lang'), require('xecore:/common/js/xe.progress'), require('xecore:/common/js/xe.request'));
  } else {
    factory((root.XE = {}), root.jQuery);
  }
}(this, function (exports, $, XeLang, XeProgress, XeRequest) {
  'use strict';

  var XE = {},
  $ = $.noConflict(true);

  // @TODO ???
  // jquery 를 구분하기 위해 버전 변경
  // $.jquery = $.jquery + '.XE';

  exports.$ = XE.jQuery = $;
  exports.Lang = XeLang;
  exports.Progress = XeProgress;
  exports.Request = XeRequest;

  // @TODO
  exports.options = {
    loadedTime: null,
    nowTime: parseInt(new Date().getTime() / 1000),
    timeLag: null
  };

  // @TODO request 설정 분리
  exports.setup = function (options) {
    this.options.loginUserId = options.loginUserId;
    this.options.loadedTime = options.loadedTime;
    this.options.timeLag = options.loadedTime - exports.options.nowTime;

    XeRequest.setup({
      headers: {
        'X-CSRF-TOKEN': options['X-CSRF-TOKEN']
      }
    });
  };

  exports.configure = function (options) {
    $.extend(exports.options, options);

  };


  exports.cssLoad = function(url) {
    $('head').append($('<link>').attr('rel', 'stylesheet').attr('href', url));
  };

  exports.toast = function (type, message) {
    if (type == '') {
      type = 'danger';
    }
    System.import('xecore:/common/js/modules/griper/griper').then(function (griper) {
      return griper.toast(type, message);
    });
  };

  exports.toastByStatus = function (status, message) {
    System.import('xecore:/common/js/modules/griper/griper').then(function (griper) {
      return griper.toast(griper.toast.fn.statusToType(status), message);
    });
  };

  exports.formError = function ($element, message) {
    System.import('xecore:/common/js/modules/griper/griper').then(function (griper) {
      return griper.form($element, message);
    });
  };

  exports.formError.clear = function ($form) {
    System.import('xecore:/common/js/modules/griper/griper').then(function (griper) {
      return griper.form.fn.clear($form);
    });
  };

  exports.validate = function ($form) {
    System.import('xecore:/common/js/modules/validator').then(function (validator) {
      validator.validate($form);
    });
  };

  if(XeRequest) {
    exports.ajax = XeRequest.ajax = function(url, options) {
      if ( typeof url === "object" ) {
        options = $.extend({}, XeRequest.options, url);
        url = undefined;
      } else {
        options = $.extend({}, options, XeRequest.options, {url: url});
        url = undefined;
      }

      var jqXHR = $.ajax(url, options);
      return jqXHR;
    };

    $.ajaxPrefilter(function(options, originalOptions, jqXHR ) {
      $.extend(options, XeRequest.options);
    });
  }

}));
