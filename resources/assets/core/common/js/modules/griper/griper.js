(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    define(['exports'], factory);
  } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
    // CommonJS
    factory(exports);
  } else {
    factory({});
  }
}(this, function (exports) {
  'use strict';

  var $ = jQuery = window.jQuery;

  var styleLoaded = false;
  //System.import('xecore:/common/js/modules/griper/style.css!');
  if(!styleLoaded) {
    styleLoaded = true;
    XE.cssLoad('/assets/core/common/js/modules/griper/style.css');
  }

  exports.options = {
    toastContainer: {
      template: '<div class="__xe_toast_container xe-toast-container"></div>',
      boxTemplate: '<div class="toast_box"></div>'
    },
    toast: {
      iconClass: {'xe-danger': 'xi-ban-circle', 'xe-info': 'xi-information-circle', 'xe-warning': 'xi-info-triangle', 'xe-success': 'xi-check'},
      expireTimes: {'xe-danger': 0, 'xe-info': 5, 'xe-warning': 10, 'xe-success': 2, 'xe-fail': 5},
      status: {500: 'warning', 401: 'info'},
      template: '<div class="alert-dismissable xe-alert" style="display:none;"><button type="button" class="__xe_close xe-btn-alert-close" aria-label="Close"><i class="xi-close"></i></button>' +
      '<span class="message"></span></div>'
    },
    form: {
      selectors: {
        elementGroup: '.form-group',
        errorText: '.__xe_error_text'
      },
      classes: {
        message: ['error-text', '__xe_error_text']
      },
      tags: {
        message: 'p'
      }
    }
  };

  exports.toast = function(type, message) {
    this.toast.fn.add(type, message);;
  };

  var toast_box = null;
  exports.toast.fn = exports.toast.prototype = {
    constructor: exports.toast,
    options: exports.options.toast,
    statusToType: function(status) {
      var type = this.options.status[status];
      return type === undefined ? 'danger' : type;
    },
    add: function(type, message) {
      exports.toast.fn.create(type, message);
      return this;
    },

    create: function(type, message) {
      var expireTime = 0;
      if (this.options.expireTimes[type] != 0) {
        expireTime = parseInt(new Date().getTime() / 1000)  + this.options.expireTimes[type];
      }

      var alert = $(this.options.template);
      alert.attr('data-expire-time', expireTime).addClass(type);
      alert.append(message);

      exports.toast.fn.container().append(alert);
      this.show(alert);
    },
    show: function(alert) {
      alert.slideDown('slow');
    },
    destroy: function(alert) {
      alert.slideUp('slow', function () {
        alert.remove();
      });
    },
    container: function() {
      if (toast_box != null) {
        return toast_box;
      }

      toast_box = $(exports.options.toastContainer.boxTemplate);
      var container = $(exports.options.toastContainer.template).append(toast_box);
      $('body').append(container);

      container.on('click', 'button.__xe_close', function (e) {
        exports.toast.fn.destroy($(this).parents('.xe-alert'));
        e.preventDefault();
      });

      setInterval(function() {
        var time = parseInt(new Date().getTime() / 1000);
        toast_box
            .find('div.xe-alert')
            .each(function() {
              var expireTime = parseInt($(this).data('expire-time'));
              if (expireTime != 0 && time > expireTime) {
                exports.toast.fn.destroy($(this));
              }
            });
      }, 1000);

      return toast_box;
    }
  };

  exports.form = function($element, message) {
    exports.form.fn.putByElement($element, message);
  };

  exports.form.fn = exports.form.prototype = {
    constructor: exports.form,
    options: exports.options.form,
    getGroup: function($element) {
      return $element.closest(this.options.selectors.elementGroup);
    },
    putByElement: function($element, message) {
      this.put(this.getGroup($element), message, $element);
    },
    put: function($group, message, $element) {
      // $group 이 1 보다 클땐 어찌 될지 모르겠음...
      if ($group.length == 1) {
        $group.append(
            $('<'+this.options.tags.message+'>')
                .addClass(this.options.classes.message.join(' '))
                .text(message)
        );
      } else if ($group.length == 0) {
        $element.after(
            $('<'+this.options.tags.message+'>')
                .addClass(this.options.classes.message.join(' '))
                .text(message)
        );
      }
    },
    clear: function($form) {
      $form.find(this.options.tags.message+this.options.selectors.errorText).remove();
    }
  };
}));
