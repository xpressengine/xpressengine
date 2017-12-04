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
  /**
   * @module griper
   * */
  var $ = jQuery = window.jQuery;

  DynamicLoadManager.cssLoad('/assets/core/common/css/griper.css');

  /**
   * @memberof module:griper
   * @name options
   * @prop {object} options
    * */
  exports.options = {
    toastContainer: {
      template: '<div class="__xe_toast_container xe-toast-container"></div>',
      boxTemplate: '<div class="toast_box"></div>',
    },
    toast: {
      classSet: {
        danger: 'xe-danger',
        positive: 'xe-positive',
        warning: 'xe-warning',
        success: 'xe-success',
        fail: 'xe-fail',
        error: 'xe-danger',
        info: 'xe-positive',
      },
      expireTimes: {
        'xe-danger': 0,
        'xe-positive': 5,
        'xe-warning': 10,
        'xe-success': 2,
        'xe-fail': 5,
      },
      status: { 500: 'xe-danger', 401: 'xe-warning' },
      template: '<div class="alert-dismissable xe-alert" style="display:none;"><button type="button" class="__xe_close xe-btn-alert-close" aria-label="Close"><i class="xi-close"></i></button>' +
      '<span class="message"></span></div>',
    },
    form: {
      selectors: {
        elementGroup: '.form-group',
        errorText: '.__xe_error_text',
      },
      classes: {
        message: ['error-text', '__xe_error_text'],
      },
      tags: {
        message: 'p',
      },
    },
  };

  /**
   * @memberof module:griper
   * @name toast
   * @function
   * @param {string} type
   * @param {string} messagge
   * @param {string} pos
   * */
  exports.toast = function (type, message, pos) {
    var position = '';

    if (navigator.userAgent.toLowerCase().indexOf('mobile') != -1) {
      if (pos && pos.indexOf('top') != -1) {
        position = 'top';
      } else {
        position = 'bottom';
      }
    } else {
      position = pos || 'bottom';

    }

    scrollToElement(type);
    this.toast.fn.add(type, message, position);
  };

  var $toastBox = null;
  var toastBoxMap = {};

  exports.toast.fn = exports.toast.prototype = {
    constructor: exports.toast,
    options: exports.options.toast,
    statusToType: function (status) {
      var type = this.options.status[status];
      return type === undefined ? 'danger' : type.split('-')[1];
    },

    add: function (type, message, pos) {
      exports.toast.fn.create(type, message, pos);
      return this;
    },

    create: function (type, message, pos) {
      var expireTime = 0;
      var type = this.options.classSet[type] || 'xe-danger';

      if (this.options.expireTimes[type] != 0) {
        expireTime = parseInt(new Date().getTime() / 1000) + this.options.expireTimes[type];
      }

      var $alert = $(this.options.template);
      $alert.attr('data-expire-time', expireTime).addClass(type).find('.message').remove();
      $alert.append(message);

      if (pos && pos.indexOf('top') != -1) {
        exports.toast.fn.container(pos).prepend($alert);
      } else {
        exports.toast.fn.container(pos).append($alert);
      }

      this.show($alert);
    },

    show: function (alert) {
      alert.slideDown('slow');
    },

    destroy: function (alert) {
      alert.slideUp('slow', function () {
        alert.remove();
      });
    },

    container: function (pos) {
      if (toastBoxMap.hasOwnProperty(pos)) {
        return toastBoxMap[pos];
      }

      var cssJSON = {};
      var direction = 'up';

      if (!pos) {
        pos = 'bottom';
      }

      switch (pos) {
        case 'top':
          $.extend(cssJSON, {
            top: 0,
            bottom: 'initial',
            margin: '0 auto',
          });
          break;

        case 'topLeft':
          $.extend(cssJSON, {
            margin: 0,
            top: 0,
            left: 0,
            right: 'initial',
            bottom: 'initial',
            minWidth: '50%',
          });
          break;

        case 'topRight':
          $.extend(cssJSON, {
            margin: 0,
            top: 0,
            right: 0,
            left: 'initial',
            bottom: 'initial',
            minWidth: '50%',
          });
          break;

        case 'bottom':
          $.extend(cssJSON, {
            bottom: 0,
            left: 0,
            right: 0,
            top: 'initial',
            margin: '0 auto',
          });
          break;

        case 'bottomLeft':
          $.extend(cssJSON, {
            margin: 0,
            bottom: 0,
            left: 0,
            right: 'initial',
            top: 'initial',
            minWidth: '50%',
          });
          break;

        case 'bottomRight':
          $.extend(cssJSON, {
            margin: 0,
            bottom: 0,
            left: 'initial',
            right: 0,
            top: 'initial',
            minWidth: '50%',
          });
          break;
      }

      $toastBox = $(exports.options.toastContainer.boxTemplate);

      var container = $(exports.options.toastContainer.template).append($toastBox).css(cssJSON);

      toastBoxMap[pos] = $toastBox;

      $('body').append(container);

      container.on('click', 'button.__xe_close', function (e) {
        exports.toast.fn.destroy($(this).parents('.xe-alert'));
        e.preventDefault();
      });

      var timeChecker = function ($box) {
        var interval;
        return function () {
          interval = setInterval(function () {
            var time = parseInt(new Date().getTime() / 1000);
            $box
              .find('div.xe-alert')
              .each(function () {
                var expireTime = parseInt($(this).data('expire-time'));
                if (expireTime != 0 && time > expireTime) {
                  exports.toast.fn.destroy($(this));
                }
              });
          }, 1000);
        };
      };

      timeChecker($toastBox)();

      return $toastBox;
    },
  };

  /**
   * @memberof module:griper
   * @name form
   * @function
   * @param {jQuery} $element
   * @param {string} message
   * */
  exports.form = function ($element, message) {
    exports.form.fn.putByElement($element, message);
    scrollToElement($element);
  };

  exports.form.fn = exports.form.prototype = {
    constructor: exports.form,
    options: exports.options.form,
    getGroup: function ($element) {
      return $element.closest(this.options.selectors.elementGroup);
    },

    putByElement: function ($element, message) {
      this.put(this.getGroup($element), message, $element);
    },

    put: function ($group, message, $element) {
      // $group 이 1 보다 클땐 어찌 될지 모르겠음...
      if ($group.length == 1) {
        $group.append(
          $('<' + this.options.tags.message + '>')
            .addClass(this.options.classes.message.join(' '))
            .text(message)
        );
      } else if ($group.length == 0) {
        $element.after(
          $('<' + this.options.tags.message + '>')
            .addClass(this.options.classes.message.join(' '))
            .text(message)
        );
      }
    },

    clear: function ($form) {
      $form.find(this.options.tags.message + this.options.selectors.errorText).remove();
    },
  };

  function scrollToElement($element) {
    if($element instanceof $) {
      $('body').animate({
        scrollTop: $element.offset().top - (window.innerHeight / 3)
      }, 1000);
    }
  }
}));
