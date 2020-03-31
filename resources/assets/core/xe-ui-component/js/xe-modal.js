/**
 * @name		jQuery xeModal plugin
 * */
;(function ($) {
  // MODAL CLASS DEFINITION
  // ======================

  var Modal = function (element, options) {
    this.options = options
    this.$body = $(document.body)
    this.$element = $(element)
    this.$dialog = this.$element.find('.xe-modal-dialog')
    this.$backdrop = null
    this.isShown = null
    this.originalBodyPad = null
    this.scrollbarWidth = 0
    this.ignoreBackdropClick = false

    if (this.options.remote) {
      this.$element
        .find('.xe-modal-content')
        .load(this.options.remote, $.proxy(function () {
          this.$element.trigger('loaded.xe.modal')
        }, this))
    }
  }

  Modal.VERSION = '3.3.6'

  Modal.TRANSITION_DURATION = 300
  Modal.BACKDROP_TRANSITION_DURATION = 150

  Modal.DEFAULTS = {
    backdrop: true,
    keyboard: true,
    show: true
  }

  Modal.prototype.toggle = function (_relatedTarget) {
    return this.isShown ? this.hide() : this.show(_relatedTarget)
  }

  Modal.prototype.show = function (_relatedTarget) {
    var _this = this
    var e = $.Event('show.xe.modal', { relatedTarget: _relatedTarget })

    this.$element.trigger(e)

    if (this.isShown || e.isDefaultPrevented()) return

    this.isShown = true

    this.checkScrollbar()
    this.setScrollbar()
    this.$body.addClass('xe-modal-open')

    this.escape()
    this.resize()

    this.$element.on('click.dismiss.xe.modal', '[data-dismiss="xe-modal"]', $.proxy(this.hide, this))

    this.$dialog.on('mousedown.dismiss.xe.modal', function () {
      _this.$element.one('mouseup.dismiss.xe.modal', function (e) {
        if ($(e.target).is(_this.$element)) _this.ignoreBackdropClick = true
      })
    })

    this.backdrop(function () {
      var transition = $.support.transition && _this.$element.hasClass('fade')

      if (!_this.$element.parent().length) {
        _this.$element.appendTo(_this.$body) // don't move modals dom position
      }

      _this.$element
        .show()
        .scrollTop(0)

      _this.adjustDialog()

      if (transition) {
        _this.$element[0].offsetWidth // force reflow
      }

      _this.$element.addClass('in show')

      _this.enforceFocus()

      var e = $.Event('shown.xe.modal', { relatedTarget: _relatedTarget })

      transition
        ? _this.$dialog // wait for modal to slide in
          .one('xeTransitionEnd', function () {
            _this.$element.trigger('focus').trigger(e)
          })
          .emulateTransitionEnd(Modal.TRANSITION_DURATION)
        : _this.$element.trigger('focus').trigger(e)
    })
  }

  Modal.prototype.hide = function (e) {
    if (e) e.preventDefault()

    e = $.Event('hide.xe.modal')

    this.$element.trigger(e)

    if (!this.isShown || e.isDefaultPrevented()) return

    this.isShown = false

    this.escape()
    this.resize()

    $(document).off('focusin.xe.modal')

    this.$element
      .removeClass('in show')
      .off('click.dismiss.xe.modal')
      .off('mouseup.dismiss.xe.modal')

    this.$dialog.off('mousedown.dismiss.xe.modal')

    if ($.support.transition && this.$element.hasClass('fade')) {
      this.$element
        // .one('xeTransitionEnd', $.proxy(this.hideModal, this))
        .emulateTransitionEnd(Modal.TRANSITION_DURATION)
      this.hideModal()
    } else {
      this.hideModal()
    }
  }

  Modal.prototype.enforceFocus = function () {
    $(document)
      .off('focusin.xe.modal') // guard against infinite focus loop
      .on('focusin.xe.modal', $.proxy(function (e) {
        if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
          this.$element.trigger('focus')
        }
      }, this))
  }

  Modal.prototype.escape = function () {
    if (this.isShown && this.options.keyboard) {
      this.$element.on('keydown.dismiss.xe.modal', $.proxy(function (e) {
        e.which == 27 && this.hide()
      }, this))
    } else if (!this.isShown) {
      this.$element.off('keydown.dismiss.xe.modal')
    }
    this.removeBackdrop()
    // this.hideModal()
  }

  Modal.prototype.resize = function () {
    if (this.isShown) {
      $(window).on('resize.xe.modal', $.proxy(this.handleUpdate, this))
    } else {
      $(window).off('resize.xe.modal')
    }
  }

  Modal.prototype.hideModal = function () {
    var _this = this
    this.$element.hide()
    this.backdrop(function () {
      _this.$body.removeClass('xe-modal-open')
      _this.resetAdjustments()
      _this.resetScrollbar()
      _this.$element.trigger('hidden.xe.modal')
    })
  }

  Modal.prototype.removeBackdrop = function () {
    this.$backdrop && this.$backdrop.remove()
    this.$backdrop = null
  }

  Modal.prototype.backdrop = function (callback) {
    var _this = this
    var animate = this.$element.hasClass('fade') ? 'fade' : ''

    if (this.isShown && this.options.backdrop) {
      var doAnimate = $.support.transition && animate

      this.$backdrop = $(document.createElement('div'))
        .addClass('xe-modal-backdrop fade ' + animate)
        .appendTo(this.$body)

      this.$element.on('click.dismiss.xe.modal', $.proxy(function (e) {
        if (this.ignoreBackdropClick) {
          this.ignoreBackdropClick = false
          return
        }

        if (e.target !== e.currentTarget) return
        this.options.backdrop == 'static'
          ? this.$element[0].focus()
          : this.hide()
      }, this))

      if (doAnimate) this.$backdrop[0].offsetWidth // force reflow

      this.$backdrop.addClass('in show')

      if (!callback) return

      doAnimate
        ? this.$backdrop
          .one('xeTransitionEnd', callback)
          .emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION)
        : callback()
    } else if (!this.isShown && this.$backdrop) {
      this.$backdrop.removeClass('in show')

      var callbackRemove = function () {
        _this.removeBackdrop()
        callback && callback()
      }

      $.support.transition && this.$element.hasClass('fade')
        ? this.$backdrop
          .one('xeTransitionEnd', callbackRemove)
          .emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION)
        : callbackRemove()
    } else if (callback) {
      callback()
    }
  }

  // these following methods are used to handle overflowing modals

  Modal.prototype.handleUpdate = function () {
    this.adjustDialog()
  }

  Modal.prototype.adjustDialog = function () {
    var modalIsOverflowing = this.$element[0].scrollHeight > document.documentElement.clientHeight

    this.$element.css({
      paddingLeft: !this.bodyIsOverflowing && modalIsOverflowing ? this.scrollbarWidth : '',
      paddingRight: this.bodyIsOverflowing && !modalIsOverflowing ? this.scrollbarWidth : ''
    })
  }

  Modal.prototype.resetAdjustments = function () {
    this.$element.css({
      paddingLeft: '',
      paddingRight: ''
    })
  }

  Modal.prototype.checkScrollbar = function () {
    var fullWindowWidth = window.innerWidth
    if (!fullWindowWidth) { // workaround for missing window.innerWidth in IE8
      var documentElementRect = document.documentElement.getBoundingClientRect()
      fullWindowWidth = documentElementRect.right - Math.abs(documentElementRect.left)
    }

    this.bodyIsOverflowing = document.body.clientWidth < fullWindowWidth
    this.scrollbarWidth = this.measureScrollbar()
  }

  Modal.prototype.setScrollbar = function () {
    var bodyPad = parseInt((this.$body.css('padding-right') || 0), 10)
    this.originalBodyPad = document.body.style.paddingRight || ''
    if (this.bodyIsOverflowing) this.$body.css('padding-right', bodyPad + this.scrollbarWidth)
  }

  Modal.prototype.resetScrollbar = function () {
    this.$body.css('padding-right', this.originalBodyPad)
  }

  Modal.prototype.measureScrollbar = function () { // thx walsh
    var scrollDiv = document.createElement('div')
    scrollDiv.className = 'xe-modal-scrollbar-measure'
    this.$body.append(scrollDiv)
    var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth
    this.$body[0].removeChild(scrollDiv)

    return scrollbarWidth
  }

  // MODAL PLUGIN DEFINITION
  // =======================

  function Plugin (option, _relatedTarget) {
    return this.each(function () {
      var $this = $(this)
      var data = $this.data('xe.modal')
      var options = $.extend({}, Modal.DEFAULTS, $this.data(), typeof option === 'object' && option)

      if (!data) $this.data('xe.modal', (data = new Modal(this, options)))
      if (typeof option === 'string') data[option](_relatedTarget)
      else if (options.show) data.show(_relatedTarget)
    })
  }

  var old = $.fn.modal

  $.fn.xeModal = Plugin
  $.fn.xeModal.Constructor = Modal

  // MODAL NO CONFLICT
  // =================

  $.fn.xeModal.noConflict = function () {
    $.fn.modal = old
    return this
  }

  // MODAL DATA-API
  // ==============

  $(document).on('click.xe.modal.data-api', '[data-toggle="xe-modal"]', function (e) {
    var $this = $(this)
    var href = $this.attr('href')
    var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) // strip for ie7
    var option = $target.data('xe.modal') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data())

    if ($this.is('a')) e.preventDefault()

    $target.one('show.xe.modal', function (showEvent) {
      if (showEvent.isDefaultPrevented()) return // only register focus restorer if modal will actually get shown
      $target.one('hidden.xe.modal', function () {
        $this.is(':visible') && $this.trigger('focus')
      })
    })

    Plugin.call($target, option, this)
  })
})(window.jQuery)
