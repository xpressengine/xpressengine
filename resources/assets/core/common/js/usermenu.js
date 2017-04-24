(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD
    define(['exports'], function (exports) {
      factory(exports);
    });
  } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
    // CommonJS
    factory(exports);
  } else {
    // Browser globals
    factory({});
  }
}(this, function (exports) {

  'use strict';

  var $ = jQuery = window.jQuery;

  var XeUserMenu = function (element, options) {
    this.type = null;
    this.options = null;
    this.enabled = null;
    this.timeout = null;
    this.hoverState = null;
    this.$element = null;

    this.init('usermenu', element, options);
  };

  XeUserMenu.VERSION = '1.0.0';

  XeUserMenu.TRANSITION_DURATION = 150;

  XeUserMenu.DEFAULTS = {
    animation: true,
    placement: 'top',
    selector: false,
    template: '<div class="ly_popup_profile xe-user-toggle-menu"><ul class="user_toggle_list"></ul></div>',
    trigger: 'hover focus',
    title: '',
    delay: 0,
    html: false,
    container: false,
    viewport: {
      selector: 'body',
      padding: 0,
    },
  };

  XeUserMenu.prototype.init = function (type, element, options) {
    this.enabled = true;
    this.type = type;
    this.$element = $(element);
    this.options = this.getOptions(options);
    this.$viewport = this.options.viewport && $(this.options.viewport.selector || this.options.viewport);

    if (this.$element[0] instanceof document.constructor && !this.options.selector) {
      throw new Error('`selector` option must be specified when initializing ' + this.type + ' on the window.document object!');
    }

    if (this.options.selector) {
      this.$element.on('click.' + this.type, $.proxy(this.toggle, this));
      this._options = $.extend({}, this.options, { trigger: 'manual', selector: '' });
    }

    var triggers = this.options.trigger.split(' ');
    for (var i = triggers.length; i--;) {
      var trigger = triggers[i];

      if (trigger == 'click') {
        this.$element.on('click.' + this.type, this.options.selector, $.proxy(this.toggle, this));
      } else if (trigger != 'manual') {
        var eventIn = trigger == 'hover' ? 'mouseenter' : 'focusin';
        var eventOut = trigger == 'hover' ? 'mouseleave' : 'focusout';

        this.$element.on(eventIn + '.' + this.type, this.options.selector, $.proxy(this.enter, this));
        this.$element.on(eventOut + '.' + this.type, this.options.selector, $.proxy(this.leave, this));
      }
    }
  };

  XeUserMenu.prototype.getDefaults = function () {
    return XeUserMenu.DEFAULTS;
  };

  XeUserMenu.prototype.getOptions = function (options) {
    options = $.extend({}, this.getDefaults(), this.$element.data(), options);

    if (options.delay && typeof options.delay == 'number') {
      options.delay = {
        show: options.delay,
        hide: options.delay,
      };
    }

    return options;
  };

  XeUserMenu.prototype.getDelegateOptions = function () {
    var options = {};
    var defaults = this.getDefaults();

    this._options && $.each(this._options, function (key, value) {
      if (defaults[key] != value) options[key] = value;
    });

    return options;
  };

  XeUserMenu.prototype.enter = function (obj) {
    var self = obj instanceof this.constructor ?
        obj : $(obj.currentTarget).data('xe.' + this.type);

    if (self && self.$menubox && self.$menubox.is(':visible')) {
      self.hoverState = 'in';
      return;
    }

    if (!self) {
      self = new this.constructor(obj.currentTarget, this.getDelegateOptions());
      $(obj.currentTarget).data('xe.' + this.type, self);
    }

    clearTimeout(self.timeout);

    self.hoverState = 'in';

    //if (!self.options.delay || !self.options.delay.show) return self.show()
    return self.show();

    /*self.timeout = setTimeout(function () {
     if (self.hoverState == 'in') self.show()
     }, self.options.delay.show)*/
  };

  XeUserMenu.prototype.leave = function (obj) {
    var self = obj instanceof this.constructor ?
        obj : $(obj.currentTarget).data('xe.' + this.type);

    if (!self) {
      self = new this.constructor(obj.currentTarget, this.getDelegateOptions());
      $(obj.currentTarget).data('xe.' + this.type, self);
    }

    clearTimeout(self.timeout);

    self.hoverState = 'out';

    if (!self.options.delay || !self.options.delay.hide) return self.hide();

    self.timeout = setTimeout(function () {
      if (self.hoverState == 'out') self.hide();
    }, self.options.delay.hide);
  };

  XeUserMenu.prototype.show = function () {
    var e = $.Event('show.xe.' + this.type);

    if (this.enabled) {
      this.$element.trigger(e);

      var inDom = $.contains(this.$element[0].ownerDocument.documentElement, this.$element[0]);
      if (e.isDefaultPrevented() || !inDom) return;
      var _this = this;

      var $menubox = this.menubox();

      var contentGenerated = function () {
        var menuId = this.type + '-' + this.getUID();

        $menubox.attr('id', menuId);
        this.$element.attr('aria-describedby', menuId);

        if (this.options.animation) $menubox.addClass('fade');

        var placement = typeof this.options.placement == 'function' ?
            this.options.placement.call(this, $menubox[0], this.$element[0]) :
            this.options.placement;

        var autoToken = /\s?auto?\s?/i;
        var autoPlace = autoToken.test(placement);
        if (autoPlace) placement = placement.replace(autoToken, '') || 'top';

        $menubox
            .detach()
            .css({ top: 0, left: 0, display: 'block' })
            .addClass(placement)
            .data('xe.' + this.type, this);

        this.options.container ? $menubox.appendTo(this.options.container) : $menubox.insertAfter(this.$element);

        var pos = this.getPosition();
        var actualWidth = $menubox[0].offsetWidth;
        var actualHeight = $menubox[0].offsetHeight;

        if (autoPlace) {
          var orgPlacement = placement;
          var $container = this.options.container ? $(this.options.container) : this.$element.parent();
          var containerDim = this.getPosition($container);

          placement = placement == 'bottom' && pos.bottom + actualHeight > containerDim.bottom ? 'top' :
              placement == 'top' && pos.top - actualHeight < containerDim.top ? 'bottom' :
                  placement == 'right' && pos.right + actualWidth > containerDim.width ? 'left' :
                      placement == 'left' && pos.left - actualWidth < containerDim.left ? 'right' :
                          placement;

          $menubox
              .removeClass(orgPlacement)
              .addClass(placement);
        }

        var calculatedOffset = this.getCalculatedOffset(placement, pos, actualWidth, actualHeight);

        this.applyPlacement(calculatedOffset, placement);

        var complete = function () {
          var prevHoverState = _this.hoverState;
          _this.$element.trigger('shown.xe.' + _this.type);
          _this.hoverState = null;

          if (prevHoverState == 'out') _this.leave(_this);
        };

        $.support.transition && this.$menubox.hasClass('fade') ?
            $menubox
                .one('bsTransitionEnd', complete)
                .emulateTransitionEnd(XeUserMenu.TRANSITION_DURATION) :
            complete();
      };

      this.setContent($menubox, $.proxy(contentGenerated, this));
    }

  };

  XeUserMenu.prototype.applyPlacement = function (offset, placement) {
    var $menubox = this.menubox();
    var width = $menubox[0].offsetWidth;
    var height = $menubox[0].offsetHeight;

    // manually read margins because getBoundingClientRect includes difference
    var marginTop = parseInt($menubox.css('margin-top'), 10);
    var marginLeft = parseInt($menubox.css('margin-left'), 10);

    // we must check for NaN for ie 8/9
    if (isNaN(marginTop))  marginTop = 0;
    if (isNaN(marginLeft)) marginLeft = 0;

    offset.top = offset.top + marginTop;
    offset.left = offset.left + marginLeft;

    // $.fn.offset doesn't round pixel values
    // so we use setOffset directly with our own function B-0
    $.offset.setOffset($menubox[0], $.extend({
      using: function (props) {
        $menubox.css({
          top: Math.round(props.top),
          left: Math.round(props.left),
        });
      },
    }, offset), 0);

    $menubox.addClass('in');

    // check to see if placing tip in new offset caused the tip to resize itself
    var actualWidth = $menubox[0].offsetWidth;
    var actualHeight = $menubox[0].offsetHeight;

    if (placement == 'top' && actualHeight != height) {
      offset.top = offset.top + height - actualHeight;
    }

    var delta = this.getViewportAdjustedDelta(placement, offset, actualWidth, actualHeight);

    if (delta.left) offset.left += delta.left;
    else offset.top += delta.top;

    var isVertical = /top|bottom/.test(placement);

    $menubox.offset(offset);
  };

  XeUserMenu.prototype.setContent = function ($menubox, callback) {

    var _this = this;
    var ul = $menubox.find('ul.user_toggle_list');
    $menubox.removeClass('fade in top bottom left right');

    if (_this.menuGenerated) {
      callback();
      return;
    } else {
      $.ajax({
        url: xeBaseURL + '/toggleMenu',
        type: 'GET',
        dataType: 'json',
        data: { type: 'user', id: this.getUID() },
        success: function (data) {
          data.forEach(function (item) {
            ul.append(_this.generateMenuItem(item));
          });

          _this.menuGenerated = true;
          callback();
        },
      });
    }
  };

  XeUserMenu.prototype.generateMenuItem = function (item) {
    if (item.type == 'raw') {
      return $('<li>').append(item.action);
    }

    var attr;
    switch (item.type) {
      case 'func' :
        attr = {
          href: '#', onClick: function (e) {
            (eval(item.action))(item.data);
            e.preventDefault();
          }.bind(this),
        };
        break;
      case 'exec' :
        attr = {
          href: '#', onClick: function (e) {
            eval(item.action);
            e.preventDefault();
          }.bind(this),
        };
        break;
      case 'link' :
        attr = { href: item.action };
        break;
    }
    return $('<li>').addClass(item.class).append($('<a></a>').attr(attr).text(item.text));
  };

  XeUserMenu.prototype.hide = function (callback) {
    var _this = this;
    var $menubox = $(this.$menubox);
    var e = $.Event('hide.xe.' + this.type);

    function complete() {
      if (_this.hoverState != 'in') $menubox.detach();
      _this.$element
          .removeAttr('aria-describedby')
          .trigger('hidden.xe.' + _this.type);
      callback && callback();
    }

    this.$element.trigger(e);

    if (e.isDefaultPrevented()) return;

    $menubox.removeClass('in');

    $.support.transition && $menubox.hasClass('fade') ?
        $menubox
            .one('bsTransitionEnd', complete)
            .emulateTransitionEnd(XeUserMenu.TRANSITION_DURATION) :
        complete();

    this.hoverState = null;

    return this;
  };

  XeUserMenu.prototype.getPosition = function ($element) {
    $element = $element || this.$element;

    var el = $element[0];
    var isBody = el.tagName == 'BODY';

    var elRect = el.getBoundingClientRect();
    if (elRect.width == null) {
      // width and height are missing in IE8, so compute them manually; see https://github.com/twbs/bootstrap/issues/14093
      elRect = $.extend({}, elRect, {
        width: elRect.right - elRect.left,
        height: elRect.bottom - elRect.top,
      });
    }

    var elOffset = isBody ? { top: 0, left: 0 } : $element.offset();
    var scroll = { scroll: isBody ? document.documentElement.scrollTop || document.body.scrollTop : $element.scrollTop() };
    var outerDims = isBody ? { width: $(window).width(), height: $(window).height() } : null;

    return $.extend({}, elRect, scroll, outerDims, elOffset);
  };

  XeUserMenu.prototype.getCalculatedOffset = function (placement, pos, actualWidth, actualHeight) {
    return placement == 'bottom' ? {
      top: pos.top + pos.height,
      left: pos.left + pos.width / 2 - actualWidth / 2,
    } :
        placement == 'top' ? {
          top: pos.top - actualHeight,
          left: pos.left + pos.width / 2 - actualWidth / 2,
        } :
            placement == 'left' ? {
              top: pos.top + pos.height / 2 - actualHeight / 2,
              left: pos.left - actualWidth,
            } :
                /* placement == 'right' */ {
              top: pos.top + pos.height / 2 - actualHeight / 2,
              left: pos.left + pos.width,
            };

  };

  XeUserMenu.prototype.getViewportAdjustedDelta = function (placement, pos, actualWidth, actualHeight) {
    var delta = { top: 0, left: 0 };
    if (!this.$viewport) return delta;

    var viewportPadding = this.options.viewport && this.options.viewport.padding || 0;
    var viewportDimensions = this.getPosition(this.$viewport);

    if (/right|left/.test(placement)) {
      var topEdgeOffset = pos.top - viewportPadding - viewportDimensions.scroll;
      var bottomEdgeOffset = pos.top + viewportPadding - viewportDimensions.scroll + actualHeight;
      if (topEdgeOffset < viewportDimensions.top) { // top overflow
        delta.top = viewportDimensions.top - topEdgeOffset;
      } else if (bottomEdgeOffset > viewportDimensions.top + viewportDimensions.height) { // bottom overflow
        delta.top = viewportDimensions.top + viewportDimensions.height - bottomEdgeOffset;
      }
    } else {
      var leftEdgeOffset = pos.left - viewportPadding;
      var rightEdgeOffset = pos.left + viewportPadding + actualWidth;
      if (leftEdgeOffset < viewportDimensions.left) { // left overflow
        delta.left = viewportDimensions.left - leftEdgeOffset;
      } else if (rightEdgeOffset > viewportDimensions.width) { // right overflow
        delta.left = viewportDimensions.left + viewportDimensions.width - rightEdgeOffset;
      }
    }

    return delta;
  };

  XeUserMenu.prototype.getUID = function () {
    return this.$element.data('userId');
  };

  XeUserMenu.prototype.menubox = function () {
    return (this.$menubox = this.$menubox || $(this.options.template));
  };

  XeUserMenu.prototype.enable = function () {
    this.enabled = true;
  };

  XeUserMenu.prototype.disable = function () {
    this.enabled = false;
  };

  XeUserMenu.prototype.toggleEnabled = function () {
    this.enabled = !this.enabled;
  };

  /* toggle은 항상 root container를 this로 가짐 */
  XeUserMenu.prototype.toggle = function (e) {
    var _this = this;
    var self = _this;
    var root = _this;

    if (e) {
      self = $(e.currentTarget).data('xe.' + this.type);
      if (!self) {
        self = new this.constructor(e.currentTarget, this.getDelegateOptions());
        $(e.currentTarget).data('xe.' + this.type, self);
      }
    }

    if (this.options.selector) {
      var others = $(this.$element).find(this.options.selector).not(self.$element);
      others.each(function () {
        var usermenu = $(this).data('xe.' + root.type);
        if (usermenu) usermenu.leave(usermenu);
      });
    }

    if (self != root) {
      e.stopPropagation();
      self.menubox().hasClass('in') ? self.leave(self) : self.enter(self);
      return false;
    }
  };

  XeUserMenu.prototype.destroy = function () {
    var _this = this;
    clearTimeout(this.timeout);
    this.hide(function () {
      _this.$element.off('.' + _this.type).removeData('xe.' + _this.type);
    });
  };

  function Plugin(option) {
    return this.each(function () {
      var $this = $(this);
      var data = $this.data('xe.usermenu');
      var options = typeof option == 'object' && option;

      if (!data && /destroy|hide/.test(option)) return;
      if (!data) $this.data('xe.usermenu', (data = new XeUserMenu(this, options)));
      if (typeof option == 'string') data[option]();
    });
  }

  var old = $.fn.xeUserMenu;

  $.fn.xeUserMenu = Plugin;
  $.fn.xeUserMenu.Constructor = XeUserMenu;

  // TOOLTIP NO CONFLICT
  // ===================

  $.fn.xeUserMenu.noConflict = function () {
    $.fn.xeUserMenu = old;
    return this;
  };

  // APPLY TO STANDARD DROPDOWN ELEMENTS
  // ===================================

  $(document).xeUserMenu({
    selector: '[data-toggle=xeUserMenu]',
    container: 'body',
    trigger: 'click',
    placement: 'bottom auto'
  });

}));
