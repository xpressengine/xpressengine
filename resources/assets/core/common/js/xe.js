(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    define([
      'exports',
      'jquery',
      'xecore:/common/js/xe.lang',
      'xecore:/common/js/xe.progress',
      'xecore:/common/js/xe.request',
      ], function (exports, $, XeLang, XeProgress, XeRequest) {
        if(typeof root.XE === "undefined") {
          factory((root.XE = exports), $, XeLang, XeProgress, XeRequest);
        }
      });
  } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
    if(typeof root.XE === "undefined") {
      factory((root.XE = exports), require('jquery'), require('xecore:/common/js/xe.lang'), require('xecore:/common/js/xe.progress'), require('xecore:/common/js/xe.request'));
    }
  } else {
    if(typeof root.XE === "undefined") {
      factory((root.XE = {}), root.jQuery);
    }
  }
}(this, function (exports, $, XeLang, XeProgress, XeRequest) {
  'use strict';

  var INSTANCE = null;

  var XE = function () {
    this.$ = this.jQuery = $;
    this.Lang = XeLang;
    this.Progress = XeProgress;
    this.Request = XeRequest;

    this.options = {
      // @DEPRECATED
      loadedTime: null,
      // @DEPRECATED
      nowTime: parseInt(new Date().getTime() / 1000),
      // @DEPRECATED
      timeLag: null
    };

    this.setup = function (options) {
      this.options.loginUserId = options.loginUserId;
      this.options.loadedTime = options.loadedTime;
      this.options.timeLag = options.loadedTime - this.options.nowTime;

      this.Request.setup({
        headers: {
          'X-CSRF-TOKEN': options['X-CSRF-TOKEN']
        }
      });
    };

    this.configure = function (options) {
      $.extend(this.options, options);

    };

    // @DEPRECATED
    this.cssLoad = function(url) {
      $('head').append($('<link>').attr('rel', 'stylesheet').attr('href', url));
    };

    this.toast = function (type, message) {
      if (type == '') {
        type = 'danger';
      }
      System.import('xecore:/common/js/modules/griper/griper').then(function (griper) {
        return griper.toast(type, message);
      });
    };

    this.toastByStatus = function (status, message) {
      System.import('xecore:/common/js/modules/griper/griper').then(function (griper) {
        return griper.toast(griper.toast.fn.statusToType(status), message);
      });
    };

    this.formError = function ($element, message) {
      System.import('xecore:/common/js/modules/griper/griper').then(function (griper) {
        return griper.form($element, message);
      });
    };

    this.formError.clear = function ($form) {
      System.import('xecore:/common/js/modules/griper/griper').then(function (griper) {
        return griper.form.fn.clear($form);
      });
    };

    this.validate = function ($form) {
      System.import('xecore:/common/js/modules/validator').then(function (validator) {
        validator.validate($form);
      });
    };

    if(this.Request) {
      var self = this;
      this.ajax = this.Request.ajax = function(url, options) {
        if ( typeof url === "object" ) {
          options = $.extend({}, self.Request.options, url);
          url = undefined;
        } else {
          options = $.extend({}, options, self.Request.options, {url: url});
          url = undefined;
        }

        var jqXHR = $.ajax(url, options);
        return jqXHR;
      };

      $.ajaxPrefilter(function(options, originalOptions, jqXHR ) {
        $.extend(options, self.Request.options);
      });
    }
  };

  var getInstance = function (){
    if (INSTANCE === null) {
      INSTANCE = new XE();
    }

    return INSTANCE;
  };

  $.extend(exports, getInstance());
}));
