window.jQuery(function ($) {
  window.PluginInstallManager = (function (XE) {
    var self

    return {
      checked: [],
      init: function () {
        self = this
        self.cache()
        self.bindEvents()
        return this
      },
      cache: function () {
        self.$installbox = $('.__xe_install_list')
        self.$installForm = $('#__xe_install_form')
        self.$list = $('.__xe_install_list ul')
        self.$items = $('.__xe_plugin_items')
      },
      bindEvents: function () {
        self.$list.on('change', 'input', self.check)
        self.$installForm.on('submit', self.install)
        self.$items.on('change', '.__xe_checkbox', self.check)
        self.$items.on('submit', 'form[data-submit=xe-plugin-items]', self.search)
        self.$items.on('click', '.__xe_plugin_items_link a', self.paging)
      },
      loaded: function (data) {
        $('.__xe-tab-list li').removeClass('on')
        $('.__xe-tab-list li.' + data.filter).addClass('on')

        if (data.filter == 'search') {
          $('.__xe-tab-list li.search').show()
        } else {
          $('.__xe-tab-list li.search').hide()
        }
        self.reset()
      },
      reset: function (data) {
        self.$items.find('.__xe_checkbox').each(function (i) {
          id = this.value
          if (self.$list.find('input[value=' + id + ']:checked').length !== 0) {
            this.checked = true
          }
        })

        var length = self.$list.find('input').length
        self.$installbox.find('.__xe_selected_count').text(length)

        if (length) {
          $('.__xe_install_btn').removeAttr('disabled')
        } else {
          $('.__xe_install_btn').attr('disabled', 'disabled')
        }
      },
      check: function (e) {
        id = $(this).data('id')
        title = $(this).data('title')

        if ($(this).data('needPurchase')) {
          alert('유료 플러그인은 미리 구매하셔야 사용가능합니다.')
          this.checked = false
          return false
        }

        if (this.checked) {
          self.add(id, title)
        } else {
          self.remove(id, title)
        }
        self.reset()
      },
      add: function (id, title) {
        if (self.$list.find('input[value=' + id + ']').length == 0) {
          var li = $('<li style="display: none;"><label class="xe-label"><input name="pluginId[]" type="checkbox" data-id="' + id + '" data-title="' + title + '" value="' + id + '" checked><span class="xe-input-helper"></span><span class="xe-label-text">' + title + '</span></label></li>')
          self.$list.append(li)
          li.slideDown()
        }
      },
      remove: function (id, title) {
        var inputInList = self.$list.find('input[value=' + id + ']')
        if (inputInList.length) {
          inputInList.parents('li').remove()
        }
        var inputInItems = self.$items.find('input[value=' + id + ']')
        if (inputInItems.length) {
          inputInItems.removeAttr('checked')
        }
      },
      search: function (e) {
        e.preventDefault()
        var $this = $(this)
        XE.page($this.attr('action'), '.__xe_plugin_items', {
          data: $this.serialize()
        }, self.loaded)
      },
      paging: function (e) {
        e.preventDefault()
        XE.page(this.href, '.__xe_plugin_items', [], self.reset)
      },
      install: function () {
        if (self.$list.find('input').length == 0) {
          return false
        }

        var count = $('.__xe_selected_count').text()

        if (confirm(count + '개의 플러그인을 설치하시겠습니까?')) {
          return true
        }
        return false
      }
    }
  })(window.XE).init()
})
