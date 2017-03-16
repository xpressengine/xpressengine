;(function () {
  var TextLimiter = function (element, options) {
    var limit = options.limit || 30;
    var limitBy = options.limitBy || 'count';
    var showLimitBox = options.showLimitBox || true;
    var position = options.position || 'outer';
    var _this = null;
    var keyPress = false;
    var tmpValue = '';

    return {
      init: function () {
        _this = this;
        _this.cache();
        _this.bindEvent();

        if (showLimitBox) {
          _this.bindTemplate(position);
        }

        return _this;
      },

      cache: function () {
        _this.$element = $(element);
      },

      bindEvent: function () {
        _this.$element.off('keydown').on('keydown', _this.onKeydown);
        _this.$element.off('keyup').on('keyup', _this.onKeyup);
        _this.$element.off('paste').on('paste', _this.onPaste);

      },

      getCurrentValues: function (e) {
        var $target = $(e.target);
        var currentValue = $target.val();
        var updatedValue = (e.type === 'paste') ? $target.val() + e.originalEvent.clipboardData.getData('Text') : $target.val() + String.fromCharCode(e.keyCode);

        return {
          currentValue: currentValue,
          updatedValue: updatedValue,
        };
      },

      countValue: function (value) {
        var count = (limitBy === 'byte') ? _this.getByteLength(value) : value.length;
        _this.$element.parent().find('.num').text(count);
      },

      onKeydown: function (e) {
        if (keyPress && [8, 46].indexOf(e.keyCode) === -1) {
          return false;
        }

        tmpValue = _this.$element.val();
        keyPress = true;

        if (options.onKeydown && typeof options.onKeyup === 'function') {
          options.onKeydown.call(element, e);
        }
      },

      onKeyup: function (e) {
        var value = _this.$element.val();
        keyPress = false;

        if (_this.isValid({ updatedValue: value })) {
          if (showLimitBox) {
            _this.countValue(value);
          }

        } else {
          _this.$element.val(tmpValue);
          _this.countValue(tmpValue);

          if (options.onOverCount && typeof options.onOverCount === 'function') {
            options.onOverCount.call(element, {
              currentValue: tmpValue,
              updatedValue: value,
            });
          }
        }

        if (options.onKeyup && typeof options.onKeyup === 'function') {
          options.onKeyup.call(element, e);
        }

      },

      onPaste: function (e) {
        _this.update(_this.getCurrentValues(e));
      },

      /**
       * @param {object} data
       * <pre>
       *   currentValue: 기존값
       *   updatedValue: 변경된 값
       * </pre>
       * */
      isValid: function (data) {
        if (limitBy === 'byte' && _this.getByteLength(data.updatedValue) > limit
          || limitBy === 'count' && data.updatedValue.length > limit) {
          return false;
        } else {
          return true;
        }
      },

      getByteLength: function (s, b, i, c) {
        for (b = i = 0; c = s.charCodeAt(i++); b += c >> 11 ? 2 : c >> 7 ? 2 : 1);
        return b;
      },

      bindTemplate: function (position) {
        var currentCount = this.$element.val().length;
        var limitBox = showLimitBox ? [
          '<p class="xe-form-sum right">',
          '(<span class="num">' + currentCount + '</span> / <span>' + limit + '</span>)',
          '</p>',
        ].join('\n') : '';

        switch (position) {
          case 'inner':
            var $limitBox = $(limitBox).addClass('inner');

            this.$element.addClass('xe-form-control').wrapAll('<div class="xe-form-group" />').before($limitBox);

          break;

          case 'outer':
            var $limitBox = $(limitBox);

            this.$element.addClass('xe-form-control').wrapAll('<div class="xe-form-group" />').before($limitBox);

          break;

          default:
        }
      },
    };
  };

  /**
   * @param options {object}
   * <pre>
   * - limit: 100 default 30,
   * - limitBy: 'byte' or 'count' default 'count',
   * - showLimitBox: true,
   * - position: 'inner' or 'outer' default 'outer',
   * - onOverCount: function() {}
   * - onKeyup: function() {}
   * - onKeydown: function() {}
   * </pre>
   * */
  $.fn.limitText = function (options) {
    return this.each(function () {
      var Component = new TextLimiter(this, options || {});

      Component.init();
    });
  };
})();
