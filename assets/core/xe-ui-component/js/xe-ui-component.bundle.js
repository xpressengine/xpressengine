System.registerDynamic("xecore:/xe-ui-component/js/_dropdown.js", [], true, function($__require, exports, module) {
  ;
  var define,
      global = this,
      GLOBAL = this;
  (function(root, factory) {
    if (typeof define === 'function' && define.amd) {
      define(['exports'], function(exports) {
        factory(exports);
      });
    } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
      factory(exports);
    } else {
      factory({});
    }
  }(this, function(exports) {
    'use strict';
    var backdrop = '.xe-dropdown-backdrop';
    var toggle = '[data-toggle="xe-dropdown"]';
    var Dropdown = function(element) {
      $(element).on('click.xe.dropdown', this.toggle);
    };
    Dropdown.VERSION = '3.3.6';
    function getParent($this) {
      var selector = $this.attr('data-target');
      if (!selector) {
        selector = $this.attr('href');
        selector = selector && /#[A-Za-z]/.test(selector) && selector.replace(/.*(?=#[^\s]*$)/, '');
      }
      var $parent = selector && $(selector);
      return $parent && $parent.length ? $parent : $this.parent();
    }
    function clearMenus(e) {
      if (e && e.which === 3)
        return;
      $(backdrop).remove();
      $(toggle).each(function() {
        var $this = $(this);
        var $parent = getParent($this);
        var relatedTarget = {relatedTarget: this};
        if (!$parent.hasClass('open'))
          return;
        if (e && e.type == 'click' && /input|textarea/i.test(e.target.tagName) && $.contains($parent[0], e.target))
          return;
        $parent.trigger(e = $.Event('hide.xe.dropdown', relatedTarget));
        if (e.isDefaultPrevented())
          return;
        $this.attr('aria-expanded', 'false');
        $parent.removeClass('open').trigger($.Event('hidden.xe.dropdown', relatedTarget));
      });
    }
    Dropdown.prototype.toggle = function(e) {
      var $this = $(this);
      if ($this.is('.disabled, :disabled'))
        return;
      var $parent = getParent($this);
      var isActive = $parent.hasClass('open');
      clearMenus();
      if (!isActive) {
        if ('ontouchstart' in document.documentElement && !$parent.closest('.navbar-nav').length) {
          $(document.createElement('div')).addClass('xe-dropdown-backdrop').insertAfter($(this)).on('click', clearMenus);
        }
        var relatedTarget = {relatedTarget: this};
        $parent.trigger(e = $.Event('show.xe.dropdown', relatedTarget));
        if (e.isDefaultPrevented())
          return;
        $this.trigger('focus').attr('aria-expanded', 'true');
        $parent.toggleClass('open').trigger($.Event('shown.xe.dropdown', relatedTarget));
      }
      return false;
    };
    Dropdown.prototype.keydown = function(e) {
      if (!/(38|40|27|32)/.test(e.which) || /input|textarea/i.test(e.target.tagName))
        return;
      var $this = $(this);
      e.preventDefault();
      e.stopPropagation();
      if ($this.is('.disabled, :disabled'))
        return;
      var $parent = getParent($this);
      var isActive = $parent.hasClass('open');
      if (!isActive && e.which != 27 || isActive && e.which == 27) {
        if (e.which == 27)
          $parent.find(toggle).trigger('focus');
        return $this.trigger('click');
      }
      var desc = ' li:not(.disabled):visible a';
      var $items = $parent.find('.xe-dropdown-menu' + desc);
      if (!$items.length)
        return;
      var index = $items.index(e.target);
      if (e.which == 38 && index > 0)
        index--;
      if (e.which == 40 && index < $items.length - 1)
        index++;
      if (!~index)
        index = 0;
      $items.eq(index).trigger('focus');
    };
    function Plugin(option) {
      return this.each(function() {
        var $this = $(this);
        var data = $this.data('xe.dropdown');
        if (!data)
          $this.data('xe.dropdown', (data = new Dropdown(this)));
        if (typeof option == 'string')
          data[option].call($this);
      });
    }
    var old = $.fn.dropdown;
    $.fn.xeDropdown = Plugin;
    $.fn.xeDropdown.Constructor = Dropdown;
    $.fn.xeDropdown.noConflict = function() {
      $.fn.dropdown = old;
      return this;
    };
    $(document).on('click.xe.dropdown.data-api', clearMenus).on('click.xe.dropdown.data-api', '.xe-dropdown form', function(e) {
      e.stopPropagation();
    }).on('click.xe.dropdown.data-api', toggle, Dropdown.prototype.toggle).on('keydown.xe.dropdown.data-api', toggle, Dropdown.prototype.keydown).on('keydown.xe.dropdown.data-api', '.xe-dropdown-menu', Dropdown.prototype.keydown);
  }));
  return module.exports;
});

System.registerDynamic("xecore:/xe-ui-component/js/_modal.js", [], true, function($__require, exports, module) {
  ;
  var define,
      global = this,
      GLOBAL = this;
  (function(root, factory) {
    if (typeof define === 'function' && define.amd) {
      define(['exports'], function(exports) {
        factory(exports);
      });
    } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
      factory(exports);
    } else {
      factory({});
    }
  }(this, function(exports) {
    'use strict';
    var Modal = function(element, options) {
      this.options = options;
      this.$body = $(document.body);
      this.$element = $(element);
      this.$dialog = this.$element.find('.xe-modal-dialog');
      this.$backdrop = null;
      this.isShown = null;
      this.originalBodyPad = null;
      this.scrollbarWidth = 0;
      this.ignoreBackdropClick = false;
      if (this.options.remote) {
        this.$element.find('.xe-modal-content').load(this.options.remote, $.proxy(function() {
          this.$element.trigger('loaded.xe.modal');
        }, this));
      }
    };
    Modal.VERSION = '3.3.6';
    Modal.TRANSITION_DURATION = 300;
    Modal.BACKDROP_TRANSITION_DURATION = 150;
    Modal.DEFAULTS = {
      backdrop: true,
      keyboard: true,
      show: true
    };
    Modal.prototype.toggle = function(_relatedTarget) {
      return this.isShown ? this.hide() : this.show(_relatedTarget);
    };
    Modal.prototype.show = function(_relatedTarget) {
      var that = this;
      var e = $.Event('show.xe.modal', {relatedTarget: _relatedTarget});
      this.$element.trigger(e);
      if (this.isShown || e.isDefaultPrevented())
        return;
      this.isShown = true;
      this.checkScrollbar();
      this.setScrollbar();
      this.$body.addClass('xe-modal-open');
      this.escape();
      this.resize();
      this.$element.on('click.dismiss.xe.modal', '[data-dismiss="xe-modal"]', $.proxy(this.hide, this));
      this.$dialog.on('mousedown.dismiss.xe.modal', function() {
        that.$element.one('mouseup.dismiss.xe.modal', function(e) {
          if ($(e.target).is(that.$element))
            that.ignoreBackdropClick = true;
        });
      });
      this.backdrop(function() {
        var transition = $.support.transition && that.$element.hasClass('fade');
        if (!that.$element.parent().length) {
          that.$element.appendTo(that.$body);
        }
        that.$element.show().scrollTop(0);
        that.adjustDialog();
        if (transition) {
          that.$element[0].offsetWidth;
        }
        that.$element.addClass('in');
        that.enforceFocus();
        var e = $.Event('shown.xe.modal', {relatedTarget: _relatedTarget});
        transition ? that.$dialog.one('xeTransitionEnd', function() {
          that.$element.trigger('focus').trigger(e);
        }).emulateTransitionEnd(Modal.TRANSITION_DURATION) : that.$element.trigger('focus').trigger(e);
      });
    };
    Modal.prototype.hide = function(e) {
      if (e)
        e.preventDefault();
      e = $.Event('hide.xe.modal');
      this.$element.trigger(e);
      if (!this.isShown || e.isDefaultPrevented())
        return;
      this.isShown = false;
      this.escape();
      this.resize();
      $(document).off('focusin.xe.modal');
      this.$element.removeClass('in').off('click.dismiss.xe.modal').off('mouseup.dismiss.xe.modal');
      this.$dialog.off('mousedown.dismiss.xe.modal');
      $.support.transition && this.$element.hasClass('fade') ? this.$element.one('xeTransitionEnd', $.proxy(this.hideModal, this)).emulateTransitionEnd(Modal.TRANSITION_DURATION) : this.hideModal();
    };
    Modal.prototype.enforceFocus = function() {
      $(document).off('focusin.xe.modal').on('focusin.xe.modal', $.proxy(function(e) {
        if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
          this.$element.trigger('focus');
        }
      }, this));
    };
    Modal.prototype.escape = function() {
      if (this.isShown && this.options.keyboard) {
        this.$element.on('keydown.dismiss.xe.modal', $.proxy(function(e) {
          e.which == 27 && this.hide();
        }, this));
      } else if (!this.isShown) {
        this.$element.off('keydown.dismiss.xe.modal');
      }
    };
    Modal.prototype.resize = function() {
      if (this.isShown) {
        $(window).on('resize.xe.modal', $.proxy(this.handleUpdate, this));
      } else {
        $(window).off('resize.xe.modal');
      }
    };
    Modal.prototype.hideModal = function() {
      var that = this;
      this.$element.hide();
      this.backdrop(function() {
        that.$body.removeClass('modal-open');
        that.resetAdjustments();
        that.resetScrollbar();
        that.$element.trigger('hidden.xe.modal');
      });
    };
    Modal.prototype.removeBackdrop = function() {
      this.$backdrop && this.$backdrop.remove();
      this.$backdrop = null;
    };
    Modal.prototype.backdrop = function(callback) {
      var that = this;
      var animate = this.$element.hasClass('fade') ? 'fade' : '';
      if (this.isShown && this.options.backdrop) {
        var doAnimate = $.support.transition && animate;
        this.$backdrop = $(document.createElement('div')).addClass('xe-modal-backdrop ' + animate).appendTo(this.$body);
        this.$element.on('click.dismiss.xe.modal', $.proxy(function(e) {
          if (this.ignoreBackdropClick) {
            this.ignoreBackdropClick = false;
            return;
          }
          if (e.target !== e.currentTarget)
            return;
          this.options.backdrop == 'static' ? this.$element[0].focus() : this.hide();
        }, this));
        if (doAnimate)
          this.$backdrop[0].offsetWidth;
        this.$backdrop.addClass('in');
        if (!callback)
          return;
        doAnimate ? this.$backdrop.one('xeTransitionEnd', callback).emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) : callback();
      } else if (!this.isShown && this.$backdrop) {
        this.$backdrop.removeClass('in');
        var callbackRemove = function() {
          that.removeBackdrop();
          callback && callback();
        };
        $.support.transition && this.$element.hasClass('fade') ? this.$backdrop.one('xeTransitionEnd', callbackRemove).emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) : callbackRemove();
      } else if (callback) {
        callback();
      }
    };
    Modal.prototype.handleUpdate = function() {
      this.adjustDialog();
    };
    Modal.prototype.adjustDialog = function() {
      var modalIsOverflowing = this.$element[0].scrollHeight > document.documentElement.clientHeight;
      this.$element.css({
        paddingLeft: !this.bodyIsOverflowing && modalIsOverflowing ? this.scrollbarWidth : '',
        paddingRight: this.bodyIsOverflowing && !modalIsOverflowing ? this.scrollbarWidth : ''
      });
    };
    Modal.prototype.resetAdjustments = function() {
      this.$element.css({
        paddingLeft: '',
        paddingRight: ''
      });
    };
    Modal.prototype.checkScrollbar = function() {
      var fullWindowWidth = window.innerWidth;
      if (!fullWindowWidth) {
        var documentElementRect = document.documentElement.getBoundingClientRect();
        fullWindowWidth = documentElementRect.right - Math.abs(documentElementRect.left);
      }
      this.bodyIsOverflowing = document.body.clientWidth < fullWindowWidth;
      this.scrollbarWidth = this.measureScrollbar();
    };
    Modal.prototype.setScrollbar = function() {
      var bodyPad = parseInt((this.$body.css('padding-right') || 0), 10);
      this.originalBodyPad = document.body.style.paddingRight || '';
      if (this.bodyIsOverflowing)
        this.$body.css('padding-right', bodyPad + this.scrollbarWidth);
    };
    Modal.prototype.resetScrollbar = function() {
      this.$body.css('padding-right', this.originalBodyPad);
    };
    Modal.prototype.measureScrollbar = function() {
      var scrollDiv = document.createElement('div');
      scrollDiv.className = 'modal-scrollbar-measure';
      this.$body.append(scrollDiv);
      var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
      this.$body[0].removeChild(scrollDiv);
      return scrollbarWidth;
    };
    function Plugin(option, _relatedTarget) {
      return this.each(function() {
        var $this = $(this);
        var data = $this.data('xe.modal');
        var options = $.extend({}, Modal.DEFAULTS, $this.data(), typeof option == 'object' && option);
        if (!data)
          $this.data('xe.modal', (data = new Modal(this, options)));
        if (typeof option == 'string')
          data[option](_relatedTarget);
        else if (options.show)
          data.show(_relatedTarget);
      });
    }
    var old = $.fn.modal;
    $.fn.xeModel = Plugin;
    $.fn.xeModel.Constructor = Modal;
    $.fn.xeModel.noConflict = function() {
      $.fn.modal = old;
      return this;
    };
    $(document).on('click.xe.modal.data-api', '[data-toggle="xe-modal"]', function(e) {
      var $this = $(this);
      var href = $this.attr('href');
      var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, '')));
      var option = $target.data('xe.modal') ? 'toggle' : $.extend({remote: !/#/.test(href) && href}, $target.data(), $this.data());
      if ($this.is('a'))
        e.preventDefault();
      $target.one('show.xe.modal', function(showEvent) {
        if (showEvent.isDefaultPrevented())
          return;
        $target.one('hidden.xe.modal', function() {
          $this.is(':visible') && $this.trigger('focus');
        });
      });
      Plugin.call($target, option, this);
    });
  }));
  return module.exports;
});

System.registerDynamic("xecore:/xe-ui-component/js/xe-ui-component.js", ["xecore:/xe-ui-component/js/_dropdown.js", "xecore:/xe-ui-component/js/_modal.js"], true, function($__require, exports, module) {
  ;
  var define,
      global = this,
      GLOBAL = this;
  (function(root, factory) {
    if (typeof define === 'function' && define.amd) {
      define(['exports', 'xecore:/xe-ui-component/js/_dropdown', 'xecore:/xe-ui-component/js/_modal'], function(exports, XeDropdown, XeModal) {
        factory(exports, $__require('xecore:/xe-ui-component/js/_dropdown.js'), $__require('xecore:/xe-ui-component/js/_modal.js'));
      });
    } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
      factory(exports, $__require('xecore:/xe-ui-component/js/_dropdown.js'), $__require('xecore:/xe-ui-component/js/_modal.js'));
    } else {
      factory({}, root.jQuery);
    }
  }(this, function(exports, XeDropdown, XeModal) {}));
  return module.exports;
});
