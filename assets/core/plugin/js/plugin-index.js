window.jQuery(function ($) {
  var PluginManager = (function (XE) {
    var self
    return {
      init: function () {
        self = this

        self.cache()
        self.bindEvents()
        self.reset()
        return this
      },
      cache: function () {
        self.$manage = $('.__xe_manage_plugin')
        self.$update = $('.__xe_update_plugin')
        self.$remove = $('.__xe_remove_plugin')
        self.$activate = $('.__xe_activate_plugin')
        self.$deactivate = $('.__xe_deactivate_plugin')
        self.$checkAll = $('.__xe_check_all')
        self.$checkboxes = $('.__xe_checkbox')

        self.$makePlugin = $('.__xe_make_plugin')
        self.$makeTheme = $('.__xe_make_theme')
        self.$makeSkin = $('.__xe_make_skin')
      },
      bindEvents: function () {
        self.$checkAll.on('click', self.checkAll)
        self.$checkboxes.on('change', self.check)
        self.$remove.on('click', self.remove)
        self.$activate.on('click', self.activate)
        self.$deactivate.on('click', self.deactivate)
        self.$update.on('click', self.update)

        self.$makePlugin.on('click', self.makePlugin)
        self.$makeTheme.on('click', self.makeTheme)
        self.$makeSkin.on('click', self.makeSkin)
      },
      reset: function () {
        var $checked = $('.__xe_checkbox:checked')
        if ($checked.length) {
          $('.__xe_controll_btn .btn').removeAttr('disabled')
        } else {
          $('.__xe_controll_btn .btn').attr('disabled', 'disabled')
        }
      },
      checkAll: function (e) {
        if ($(this).hasClass('on')) {
          $(this).removeClass('on')
          $('.__xe_checkbox').prop('checked', false)
        } else {
          $(this).addClass('on')
          $('.__xe_checkbox').prop('checked', true)
        }
        self.reset()
      },
      check: function (e) {
        self.reset()
      },
      checkedList: function () {
        return $('input.__xe_checkbox:checked').map(function () {
          return this.value
        }).get()
      },
      remove: function () {
        var pluginIds = []
        if ($(this).data('plugin-id')) {
          pluginIds = [$(this).data('plugin-id')]
        } else {
          pluginIds = self.checkedList()
        }

        if (pluginIds.length === 0) {
          return false
        }
        var options = {
          'data': {
            'pluginId': pluginIds.join()
          }
        }
        var url = self.$remove.attr('href')
        XE.pageModal(url, options)

        return false
      },
      activate: function () {
        var pluginIds = []
        if ($(this).data('plugin-id')) {
          pluginIds = [$(this).data('plugin-id')]
        } else {
          pluginIds = self.checkedList()
        }

        if (pluginIds.length === 0) {
          return false
        }
        var options = {
          'data': {
            'pluginId': pluginIds.join()
          }
        }
        var url = self.$activate.attr('href')
        XE.pageModal(url, options)

        return false
      },
      deactivate: function () {
        var pluginIds = []
        if ($(this).data('plugin-id')) {
          pluginIds = [$(this).data('plugin-id')]
        } else {
          pluginIds = self.checkedList()
        }

        if (pluginIds.length === 0) {
          return false
        }
        var options = {
          'data': {
            'pluginId': pluginIds.join()
          }
        }
        var url = self.$deactivate.attr('href')
        XE.pageModal(url, options)

        return false
      },
      update: function () {
        var url = self.$update.attr('href')
        XE.pageModal(url)

        return false
      },

      makePlugin: function () {
        var url = self.$makePlugin.attr('href')
        XE.pageModal(url)

        return false
      },
      makeTheme: function () {
        var url = self.$makeTheme.attr('href')
        XE.pageModal(url)

        return false
      },
      makeSkin: function () {
        var url = self.$makeSkin.attr('href')
        XE.pageModal(url)

        return false
      }
    }
  })(window.XE).init()
})
