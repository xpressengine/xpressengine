(function ($) {
  'use strict'

  /**
   * @class
   * */
  function Draft(elem, key, callback, withForm, container, apiUrl) {
    var _this = this;
    this.key = key;
    this.elem = elem;
    this.callback = callback;
    this.withForm = withForm;
    this.container = container;
    this.apiUrl = apiUrl;

    this.interval = null;

    this.draftId = null;
    this.component = null;
    this.$component = $();
    this.componentName = '';
    this.uid = null;

    if (!$(this.elem).attr('name') || $(this.elem).attr('name') == '') {
      console.error("Must set 'name' attribute ");
      return;
    }

    this.init();
    this.bindEvents();
    this.load({ key: key }, function (data) {
      data.forEach(function (obj, i) {
        if (obj.is_auto === 1) {
          $(_this.elem).val(obj.val);
          _this.callback(obj);
          return;
        }
      });
    });

    return this;
  }

  /**
   * @lends Draft
   * */
  Draft.prototype = {
    /**
     * 초기화한다.
     * @function
     * */
    init: function () {
      this.uid = this._getUid();
      this.appendComponent();

    },

    _getUid: function () {
      return Math.random().toString(36).substring(2, 15) +
        Math.random().toString(36).substring(2, 15);
    },

    bindEvents: function () {
      var _this = this;

      $(this.elem).on('input.draft', function () {
        _this.saveEventHandler();
      });

      _this.$component.on('click', '.draft_title', function (e) {
        e.preventDefault();
        var $this = $(this);
        var type = $this.data('type');
        var item = $(this).data('item');

        _this.onApply(item);

        switch (type) {
          case 'modal':
            _this.$component.xeModal('hide');
            break;
          case 'collapse':
            _this.$component.collapse('hide').find('.panel-body').empty();
            break;
        }
      });

      _this.$component.on('click', '.xe-draftBtnCloseModal', function () {
        _this.$component.xeModal('hide');
      });

      _this.$component.on('click', '.btn_draft_delete', function (e) {
        e.preventDefault();

        var $this = $(this);
        var id = $this.data('id');

        _this.reqDelete(id, function () {
          $this.closest('li').remove();
        });

      });

      $(_this.elem).closest('form').on('submit', function (e) {
        _this.deleteAuto(_this.autoDraftId);
      });
    },

    toggle: function (show) {
      var _this = this;

      switch (this.componentName) {
        case 'modal':
          if (!show && _this.$component.hasClass('in')) {
            _this.$component.xeModal('hide');

          } else {
            _this.load({ key: _this.key }, function (data) {
              var temp = `<div class="draft_save_list">`;
              temp +=  `<ul>`;

              data.forEach(function (item, i) {
                temp +=    `<li>`;
                temp +=      `<a href='#' class='draft_title' data-item='${JSON.stringify(item)}' data-type="modal">${item.val}</a>`;
                temp +=      `<div class="draft_info">`;

                if (item.is_auto == 1) {
                  temp +=        `<span class="draft_state">${XE.Lang.trans('xe::autoSave')}</span>`;
                } else {
                  temp +=        `<span class="draft_state v2">${XE.Lang.trans('xe::draftSave')}</span>`;
                }

                temp +=        `<span class="draft_date">${item.created_at.substr(0, 16).replace(/-/g, ' ')}</span>`;
                temp +=        `<a href="#" class="btn_draft_delete" data-id="${item.id}"><i class="xi-close"></i></a>`;
                temp +=      `</div>`;
                temp +=     `</li>`;
              });

              temp +=    `</ul>`;
              temp +=  `</div>`;

              _this.$component.find('.xe-modal-body').html(temp);
              _this.$component.xeModal('show');
            });
          }

          break;
        case 'collapse':

          if (!show && _this.$component.hasClass('in')) {
            _this.$component.collapse('hide');

          } else {
            _this.load({ key: _this.key }, function (data) {
              var temp = `<div class="draft_save_list">`;
              temp +=  `<ul>`;

              data.forEach(function (item, i) {
                temp +=    `<li>`;
                temp +=      `<a href='#' class='draft_title' data-item='${JSON.stringify(item)}' data-type="collapse">${$($.parseHTML(item.val)).text()}</a>`;
                temp +=      `<div class="draft_info">`;

                if (item.is_auto == 1) {
                  temp +=        `<span class="draft_state">${XE.Lang.trans('xe::autoSave')}</span>`;
                } else {
                  temp +=        `<span class="draft_state v2">${XE.Lang.trans('xe::draftSave')}</span>`;
                }

                temp +=        `<span class="draft_date">${item.created_at.substr(0, 16).replace(/-/g, ' ')}</span>`;
                temp +=        `<a href="#" class="btn_draft_delete" data-id="${item.id}"><i class="xi-close"></i></a>`;
                temp +=      `</div>`;
                temp +=     `</li>`;
              });

              temp +=    `</ul>`;
              temp +=  `</div>`;

              _this.$component.find('.panel-body').html(temp);
              _this.$component.collapse('show');
            });
          }

          break;
      }
    },

    getModalTemplate: function () {
      return [
      '<div class="xe-modal fade" id="xe-draftModal">',
        '<div class="xe-modal-dialog">',
          '<div class="xe-modal-content">',
            '<div class="xe-modal-header">',
              '<button type="button" class="btn-close xe-draftBtnClose" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>',
              '<strong class="xe-modal-title"></strong>',
            '</div>',
            '<div class="xe-modal-body"></div>',
            '<div class="xe-modal-footer">',
              '<button type="button" class="xe-btn xe-btn-default" data-dismiss="xe-modal">Close</button>',
            '</div>',
          '</div>',
        '</div>',
      '</div>',
      ].join('\n');
    },

    getCollapseTemplate: function () {
      return [
        '<div class="panel panel-default">',
          '<div class="panel-body"></div>',
        '</div>',
      ].join('\n');
    },

    appendComponent: function () {
      var _this = this;
      var $container = $('<div>');

      if ($(this.container).length < 1) {
        $(this.elem).closest('form').after($container.html(this.getModalTemplate()));
        this.componentName = 'modal';
        this.$component = $('#xe-draftModal');

      } else {

        this.componentName = 'collapse';
        this.$component = $(this.container);

        var collapseClass = this._collapseClass();

        this.$component.addClass([collapseClass, 'collapse'].join(' ')).html($container.html(_this.getCollapseTemplate()));
      }
    },

    onApply: function (data) {
      var _this = this;
      this.setId(data.id);

      var values = data.etc;
      values[$(_this.elem).attr('name')] = data.val;

      dataSetter.init($(_this.elem).closest('form')[0], values);
      this.callback(values);
    },

    _collapseClass: function () {
      return '__xe_draft_collapse_' + this.uid;
    },

    saveEventHandler: function () {
      var _this = this;
      this.intervalClear();

      this.interval = setTimeout(function () {
        _this.setAuto();
        _this.intervalClear();
      }, 3000);
    },

    intervalClear: function () {
      if (this.interval) {
        clearTimeout(this.interval);
      }
    },

    draftSet: function () {
      if ($.trim($(this.elem).val()) == '') {
        return;
      }

      if (this.draftId == null) {
        this.reqPost();
      } else {
        this.reqPut();
      }
    },

    reqPost: function () {
      $.ajax({
        url: this.apiUrl.draft.add,
        type: 'post',
        dataType: 'json',
        data: this.getReqSerialize() + '&key=' + this.key,
        success: function (json) {
          if (json.draftId === null) {
            this.unsetId();
          } else {
            this.setId(json.draftId);
          }
        }.bind(this),
      });
    },

    reqPut: function () {
      $.ajax({
        url: this.apiUrl.draft.update + '/' + this.draftId,
        type: 'post',
        dataType: 'json',
        data: this.getReqSerialize(),
        success: function (json) {
          var _this = this;

          if (json.draftId === null) {
            this.$component.find('li > a').each(function () {
              var $this = $(this);
              var item = $this.data('item');

              if (item.id === _this.draftId) {
                var value = $(_this.elem).val();

                item.val = value;
                item.etc.content = value;

                $this.data('item', item).text($($.parseHTML(value)).text());
                return;
              }
            });

            this.unsetId();
          }
        }.bind(this),
      });
    },

    setAuto: function () {
      $.ajax({
        url: this.apiUrl.auto.set,
        type: 'post',
        data: this.getReqSerialize() + '&key=' + this.key,
      });
    },

    deleteAuto: function (key) {
      var key = key || this.key;

      if (key) {
        $.ajax({
          url: this.apiUrl.auto.unset,
          type: 'post',
          data: 'key=' + key,
        });
      }
    },

    load: function (param, callback) {
      var _this = this;

      $.ajax({
        url: _this.apiUrl.draft.list,
        type: 'get',
        dataType: 'json',
        data: param,
        success: function (data) {
          data.forEach(function (obj, i) {
            if (obj.is_auto === 1) {
              _this.autoDraftId = obj.id;
              return;
            }
          });

          if (callback) {
            callback(data);
          }
        },
      });
    },

    getReqSerialize: function () {
      var data;
      if (this.withForm === true) {
        data = $(this.elem).closest('form').serialize();
      } else {
        data = [$(this.elem).attr('name'), $(this.elem).val()].join('=');
      }

      return data + '&rep=' + $(this.elem).attr('name');
    },

    reqDelete: function (id, callback) {
      var _this = this;
      id = id || this.draftId;

      if (!id) {
        return;
      }

      if (id == this.draftId) {
        this.draftId = null;
      }

      $.ajax({
        url: _this.apiUrl.draft.delete + '/' + id,
        type: 'post',
        dataType: 'json',
        success: function () {
          if (callback) {
            callback();
          }
        },
      });
    },

    setId: function (id) {
      this.draftId = id;
    },

    unsetId: function () {
      this.draftId = null;
    },
  };

  var dataSetter = {
    init: function (form, data) {
      for (var i in data) {
        var name = i;
        if (data[i] instanceof Array) {
          name = name + '[]';
          this.multiple(form[name], data[i]);
        } else {
          this.single(form[name], data[i]);
        }
      }
    },

    multiple: function (selector, values) {
      if ($(selector).is(':checkbox')) {
        $.each(values, function (i, val) {
          this.toCheckbox(selector, val);
        }.bind(this));
      } else {
        $.each(values, function (i, val) {
          this.toInput($(selector).eq(i)[0], val);
        }.bind(this));
      }
    },

    single: function (selector, value) {
      if ($(selector).is(':checkbox')) {
        this.toCheckbox(selector, value);
      } else if ($(selector).is(':radio')) {
        this.toRadio(selector, value);
      } else if ($(selector).is('select')) {
        this.toSelect(selector, value);
      } else {
        this.toInput(selector, value);
      }
    },

    toCheckbox: function (elem, val) {
      $(elem).each(function () {
        if ($(this).attr('value') == val) {
          $(this).prop('checked', true);
          return false;
        }
      });
    },

    toRadio: function (elem, val) {
      $(elem).each(function () {
        if ($(this).attr('value') == val) {
          $(this).prop('checked', true);
          return false;
        }
      });
    },

    toSelect: function (elem, val) {
      $(elem).children().each(function () {
        if ($(this).attr('value') == val) {
          $(this).prop('selected', true);
          return false;
        }
      });
    },

    toInput: function (elem, val) {
      if (!$(elem).is('input[type=hidden]')) {
        $(elem).val(val);
      }
    },
  };

  $.fn.draft = function (args) {
    var defaultArgs = {
      container: null,
      withForm: false,
      callback: null,
    };

    args = $.extend({}, defaultArgs, args);

    if (!args.key || !args.btnLoad || !args.btnSave) {
      console.error('must need key, btnLoad and btnSave');
      return false;
    }

    var draft = new Draft(this, args.key, args.callback, args.withForm, args.container, args.apiUrl);

    $(args.btnLoad).unbind('click.draft').bind('click.draft', function (e) {
      e.preventDefault();

      draft.toggle(true);
    });

    $(args.btnSave).unbind('click.draft').bind('click.draft', function (e) {
      e.preventDefault();

      draft.draftSet();
    });

    return draft;
  };

})(jQuery);
