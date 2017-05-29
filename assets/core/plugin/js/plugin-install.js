$(document).ready(function () {

  window.PluginInstallManager = (function () {

    var self;

    return {
      checked: [],
      init: function () {
        self = this;
        self.cache();
        self.bindEvents();
        return this;
      },
      cache: function () {
        self.$installbox = $('.__xe_install_list');
        self.$form = $('#__xe_install_form');
        self.$list = $('.__xe_install_list ul');
        self.$items = $('.__xe_plugin_items');
      },
      bindEvents: function () {
        self.$items.on('change', '.__xe_checkbox', self.check);
        self.$list.on('change', 'input', self.check);
        self.$form.on('submit', self.install);
      },
      reset: function () {
        self.$items.find('.__xe_checkbox').each(function(i){
          id = this.value;
          if (self.$list.find('input[value=' + id + ']:checked').length !== 0) {
            this.checked = true;
          }
        });

        var length = self.$list.find('input').length;
        self.$installbox.find('.__xe_selected_count').text(length);

        if(length) {
          $('.__xe_install_btn').removeAttr('disabled');
        } else {
          $('.__xe_install_btn').attr('disabled', 'disabled');
        }

      },
      check: function (e) {
        id = $(this).data('id');
        title = $(this).data('title');

        if(this.checked) {
          self.add(id, title);
        } else {
          self.remove(id, title);
        }
        self.reset();

      },
      add: function (id, title) {
        if (self.$list.find('input[value=' + id + ']').length == 0) {
          self.$list.append('<li><label><input name="pluginId[]" type="checkbox" data-id="' + id + '" data-title="' + title + '" value="' + id + '" checked>' + title + '</label></li>')
        }
      },
      remove: function (id, title) {
        var inputInList = self.$list.find('input[value=' + id + ']');
        if(inputInList.length) {
          inputInList.parents('li').remove();
        }
        var inputInItems = self.$items.find('input[value=' + id + ']');
        if(inputInItems.length) {
          inputInItems.removeAttr('checked');
        }
      },
      install: function () {
        if (self.$list.find('input').length == 0) {
          return false;
        }
        
        var count = $('.__xe_selected_count').text();

        if (confirm(count + '개의 플러그인을 설치하시겠습니까?')) {
          return true;
        }
        return false;
      },
    }
  })().init();


  $(document).on('submit', 'form[data-submit=xe-plugin-items]', function (e) {
    e.preventDefault();

    var $this = $(this);

    XE.page($this.attr('action'), '.__xe_plugin_items', {
        data: $this.serialize(),
    }, PluginInstallManager.reset)

  });

  $('.__xe_install_form').submit(function(){

  })

  $(document).on('click', '.__xe_plugin_items_link a', function (e) {
    e.preventDefault();

    XE.page(this.href, '.__xe_plugin_items', [], PluginInstallManager.reset);
  })


});
