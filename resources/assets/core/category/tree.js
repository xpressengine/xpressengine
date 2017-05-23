(function (window, $, XE) {
'use strict'

var categoryTree = {
  init: function (container, urls) {
    container = $(container)[0];

    var o = new Tree(
      container,
      $.extend({}, this.defaultUrls, urls)
    );

    o.init();

    return o;
  },

  defaultUrls: {
    load: null,
    add: null,
    modify: null,
    remove: null,
    move: null,
  },
};

function Tree(container, urls) {
  this.container = container;
  this.urls = urls;

  this.newBoxClass = '__xe_sortable-new';

  this.boxClass = '__xe_sortable';
  this.treeBox = null;

  this.repo = new DataCache();
}

Tree.prototype = {
  init: function () {
    $(this.container).addClass('panel board-category');

    $('<div>').addClass('panel-body').append(
      $('<ul>').addClass(this.boxClass + ' item-container')
    ).appendTo(this.container);

    this.treeBox = $('> .panel-body > ul', this.container)[0];

    $(this.treeBox).nestedSortable({
      forcePlaceholderSize: true,

      // handle: 'header',
      handle: '.handler',
      cancel: '',
      helper: 'clone',
      listType: 'ul',
      items: 'li',
      opacity: .6,
      placeholder: 'item copy',
      tolerance: 'pointer',
      toleranceElement: '> div',
      isTree: true,

      // startCollapsed: true,
      relocate: function (e, locate) {
        this.move(locate.item[0]);
      }.bind(this),
      isAllowed: function ($placeholder, $parent, $item) {
        if ($parent && $parent.data('is_loading') === true) {
          return false;
        }

        return true;
      },
    });

    this.drawNew();

    this.attachToggleChildren();

    // this.attachActive();
    this.attachToggleBtns();

    this.load(null, function (nodes) {
      for (var i in nodes) {
        this.add(nodes[i], null);
      }
    }.bind(this));
  },

  drawNew: function () {
    var _this = this;

    var $item = $('<div>').addClass(this.newBoxClass + ' panel-heading').append(
      $('<div>').addClass('pull-left').append(
        $('<h3>').addClass('panel-title').text('카테고리')
      )
    ).append(
      $('<div>').addClass('pull-right').append(
        $('<button>').addClass('btn btn-primary __xe_btn_new').append(
          $('<i>').addClass('xi-plus')
        ).append(
          $('<span>').text(XE.Lang.trans('xe::addItem'))
        )
      )
    ).append(itemMaker.getBody());

    $('.__xe_btn_new', $item).click(function () {
      _this.closeBodyAll();

      if (!$item.hasClass('open')) {
        var $form = formProvider.make('create', null, _this.onCreate.bind(_this));
        $('.__xe_content_body', $item).empty().append($form);
        $form.find('.lang-editor-box').each(function () {
          langEditorBoxRender($(this));
        });

        $item.addClass('open');
      } else {
        $item.removeClass('open');
      }
    });

    $item.prependTo(this.container);
  },

  load: function (parentId, callback) {
    var data = parentId ? { id: parentId } : null;

    XE.ajax({
      url: this.urls.load,
      type: 'get',
      data: data,
      dataType: 'json',
      success: function (nodes) {
        callback(nodes);
      },
    });
  },

  add: function (data, parentId) {
    var box = this.getChildrenBox(parentId);
    if ($('#' + itemMaker.makeIdAttr(data.id)).is('li') !== true) {
      $(box).append(itemMaker.make(data));
    }

    this.repo.set(data);
  },

  move: function (item) {
    var id = itemMaker.extractId(item);
    var info = this.getNestedInfo(id);
    var parentInfo = this.getNestedInfo(info.parent_id);
    var ordering = 0;
    var children = this.getChildrenInfo(parentInfo.item_id);

    $.each(children, function (i, o) {
      if (o.item_id == id) {
        ordering = i;
        return false;
      }
    });

    XE.ajax({
      url: this.urls.move,
      type: 'post',
      dataType: 'html',
      data: { id: id, parentId: parentInfo.item_id, ordering: ordering },
      success: function () {
        var $parent = $('#' + itemMaker.makeIdAttr(parentInfo.item_id));
        if ($parent.data('is_loaded') !== true) {
          $('> .__xe_item_block .__xe_btn_toggle_children', $parent).trigger('click');
        }
      },
    });
  },

  onRemove: function (e, data) {
    $('#' + itemMaker.makeIdAttr(data.id)).hide();

    var _this = this;
    XE.ajax({
      url: this.urls.remove,
      type: 'post',
      dataType: 'html',
      data: { id: data.id },
      success: function () {
        $('#' + itemMaker.makeIdAttr(data.id)).remove();
        _this.repo.remove(data.id);
      },

      error: function () {
        $('#' + itemMaker.makeIdAttr(data.id)).show();
      },
    });
  },

  onCreate: function (e, form) {
    e.preventDefault();
    var _this = this;
    var data = this.serializeObject(form);

    // todo: validation 임시 제거
    // if (!data.word || $.trim(data.word) == '') {
    //     XE.toast('warning', XE.Lang.trans('xe::required', {name: XE.Lang.trans('xe::word')}));
    //     return false;
    // }

    $('button', form).prop('disabled', true);

    XE.ajax({
      url: this.urls.add,
      type: 'post',
      dataType: 'json',
      data: data,
      success: function (node) {
        if (data.parentId) {
          var $parent = $('#' + itemMaker.makeIdAttr(data.parentId));
          _this.closeBody($parent);
          if ($parent.data('is_loaded') !== true) {
            $('> .__xe_item_block .__xe_btn_toggle_children', $parent).trigger('click');
            return;
          }
        }

        // create new form close
        $('> .' + _this.newBoxClass, _this.container).removeClass('open');

        _this.add(node, data.parentId);
      },

      complete: function () {
        $('button', form).prop('disabled', false);
      },
    });
  },

  onEdit: function (e, form) {
    e.preventDefault();
    var _this = this;
    var data = this.serializeObject(form);

    if (!data.id || $.trim(data.id) == '') {
      XE.toast('warning', XE.Lang.trans('xe::required', { name: 'id' }));
      return false;
    }

    // todo: validation 임시 제거
    // if (!data.word || $.trim(data.word) == '') {
    //     XE.toast('warning', XE.Lang.trans('xe::required', {name: XE.Lang.trans('xe::word')}));
    //     return false;
    // }

    $('button', form).prop('disabled', true);

    XE.ajax({
      url: this.urls.modify,
      type: 'post',
      dataType: 'json',
      data: data,
      success: function (node) {
        var $item = $('#' + itemMaker.makeIdAttr(node.id));
        $('> .__xe_item_block .__xe_word', $item).text(node.readableWord);
        _this.repo.set(node);

        _this.closeBody($item);
      },

      complete: function () {
        $('button', form).prop('disabled', false);
      },
    });
  },

  serializeObject: function (form) {
    var fields = $(form).serializeArray();
    var obj = {};

    $.each(fields, function (i, field) {
      obj[field.name] = field.value;
    });

    return obj;
  },

  getChildrenBox: function (id) {
    if (!id) {
      return this.treeBox;
    }

    return $('> ul', '#' + itemMaker.makeIdAttr(id))[0];
  },

  getNestedInfo: function (id) {
    var arr = $(this.treeBox).nestedSortable('toArray', { startDepthCount: 0 });
    var info = null;
    $.each(arr, function (i, o) {
      if (o.item_id == id) {
        info = o;
        return false;
      }
    });

    return info;
  },

  getChildrenInfo: function (id) {
    var arr = $(this.treeBox).nestedSortable('toArray', { startDepthCount: 0 });
    var children = [];
    $.each(arr, function (i, o) {
      if (o.parent_id == id && o.item_id) {
        children.push(o);
      }
    });

    children = children.sort(function (a, b) {
      if (a.left == b.left) {
        return 0;
      }

      return a.left < b.left ? -1 : 1;
    });

    return children;
  },

  getBreadcrumbs: function (id) {
    var info = this.getNestedInfo(id);
    var breadcrumbs = [];

    if (info.parent_id !== null) {
      breadcrumbs = this.getBreadcrumbs(info.parent_id);
    }

    breadcrumbs.push(id);

    return breadcrumbs;
  },

  attachToggleChildren: function () {
    var _this = this;

    $(this.treeBox).on('click', '.__xe_btn_toggle_children', function (e) {
      e.stopPropagation();

      var $item = $(this).closest('li');
      var id = itemMaker.extractId($item[0]);

      if ($item.data('is_loading') === true) {
        return false;
      }

      $($item).toggleClass('__xe_state_open').toggleClass('__xe_state_close');

      if ($item.data('is_loaded') !== true) {
        $item.data('is_loading', true);
        _this.load(id, function (nodes) {
          if ($(_this.getChildrenBox(id)).is('ul') !== true) {
            $('<ul>').appendTo('#' + itemMaker.makeIdAttr(id));
          }

          for (var i in nodes) {
            _this.add(nodes[i], id);
          }

          $item.data('is_loaded', true);
          $item.data('is_loading', false);

          _this.setToggleChildrenIcon($item);
        });
      }

      _this.setToggleChildrenIcon($item);
    });
  },

  attachToggleBtns: function () {
    var _this = this;

    $(this.treeBox).on('click', '.__xe_toggle-btns > .btn', function () {
      if ($(this).hasClass('on')) {
        _this.closeBody($(this).closest('li'));
        return;
      }

      $('.__xe_toggle-btns > .btn', _this.treeBox).removeClass('on');
      $(this).addClass('on');

      $('.item', _this.treeBox).removeClass('open');
      $(this).closest('li').addClass('open');

      var action = $(this).data('action');
      var submitHandler = action === 'child' ? _this.onCreate : _this.onEdit;
      var id = itemMaker.extractId($(this).closest('li')[0]);

      var $form = formProvider.make(action, _this.repo.get(id), submitHandler.bind(_this), _this.onRemove.bind(_this));

      $('.__xe_content_body', $(this).closest('.__xe_item_block')).empty().append($form);
      $form.find('.lang-editor-box').each(function () {
        langEditorBoxRender($(this));
      });
    });
  },

  closeBody: function ($item) {
    $item.removeClass('open');
    $('> .__xe_item_block .__xe_toggle-btns .btn.on', $item).removeClass('on');
  },

  closeBodyAll: function () {
    var _this = this;
    $(this.treeBox).find('li.open').each(function () {
      _this.closeBody($(this));
    });
  },

  setToggleChildrenIcon: function ($item) {
    var $btn = $('> .__xe_item_block .__xe_btn_toggle_children', $item);

    $($btn).removeClass('xi-angle-right xi-angle-down xi-refresh xi-spin');

    if ($item.data('is_loading') === true) {
      $($btn).addClass('xi-refresh xi-spin');
    } else {
      if ($item.hasClass('__xe_state_open')) {
        $($btn).addClass('xi-angle-down');
      } else {
        $($btn).addClass('xi-angle-right');
      }
    }

    if ($item.hasClass('__xe_state_open')) {
      $('> ul', $item).show();
    } else {
      $('> ul', $item).hide();
    }
  },
};

function DataCache() {
  this.cache = {};
}

DataCache.prototype = {
  set: function (data) {
    this.cache[data.id] = data;
  },

  get: function (id) {
    return this.cache[id];
  },

  remove: function (id) {
    delete this.cache[id];
  },
};

var itemMaker = {
  prefix: 'item',
  expression: '_',
  makeIdAttr: function (id) {
    return this.prefix + this.expression + id;
  },

  extractId: function (elem) {
    var idAttr = $(elem).attr('id');
    if (!idAttr) {
      return null;
    }

    return idAttr.replace(this.prefix + this.expression, '');
  },

  make: function (data) {
    var item = $('<li>')
      .attr('id', this.makeIdAttr(data.id))
      .addClass('item __xe_state_close')
      .append(
        $('<div>').addClass('item-content __xe_item_block')
          .append(
            $('<button>').addClass('btn handler').append($('<i>').addClass('xi-drag-vertical'))
          )
          .append(this.getHeader(data))
          .append(this.getBtns())
          .append(this.getBody())
      );

    return item;
  },

  getHeader: function (data) {
    var header = $('<div>').addClass('item-info').append(
      $('<i>').addClass('xi-angle-right __xe_btn_toggle_children').css('cursor', 'pointer')
    ).append(
      $('<strong>').addClass('__xe_word').text(data.readableWord)
    );

    return header;
  },

  getBtns: function () {
    var btns = $('<div>').addClass('edit-btn-area __xe_toggle-btns').append(
      $('<button>').addClass('btn').data('action', 'edit').append($('<i>').addClass('xi-pen'))
    ).append(
      $('<button>').addClass('btn').data('action', 'child').append($('<i>').addClass('xi-plus'))
    );

    return btns;
  },

  getBody: function () {
    var body = $('<div>').addClass('panel panel-edit __xe_content_body');

    return body;
  },
};

var formProvider = {
  make: function (action, data, submitHandler, removeHandler) {
    var $form = this.getForm(action, data);
    $form.submit(function (e) {
      submitHandler(e, this);
    });

    $('.__xe_btn_remove', $form).click(function (e) {
      removeHandler(e, data, this);
    });

    return $form;
  },

  removeBtn: function (data, removeHandler) {
    return $('<span>').addClass('pull-right').css('cursor', 'pointer').append(
      $('<i>').addClass('xi-trash')
    ).click(function (e) {
      removeHandler(e, data, this);
    });
  },

  getForm: function (action, data) {
    var id = null;
    switch (action) {
    case 'child':
      id = data.id;
    case 'create':
      return this._create(id);
    break;
    case 'edit':
      return this._edit(data);
    break;
  }

  },

  _create: function (parentId) {
    var $form = $('<form>');

    $('<div>').addClass('panel-heading').append(
      $('<div>').addClass('pull-left').append(
        $('<strong>').addClass('panel-title').text(parentId ? XE.Lang.trans('xe::createChild') : XE.Lang.trans('xe::create'))
      )
    ).appendTo($form);

    $('<div>').addClass('panel-body').append(
      $('<div>').addClass('form-group')
        .append($('<label>').text(XE.Lang.trans('xe::word')))
        .append(
          $('<div>').addClass('lang-editor-box').data({
          name: 'word',
          autocomplete: false,
        })
        )
    ).append(
      $('<div>').addClass('form-group')
        .append($('<label>').text(XE.Lang.trans('xe::description')))
        .append(
          $('<div>').addClass('lang-editor-box').data({
          name: 'description',
          multiline: true,
          autocomplete: false,
        })
        )
    ).appendTo($form);

    var btns = $('<div>').addClass('pull-right').append(
      $('<button>').attr('type', 'submit').addClass('btn btn-primary').text(XE.Lang.trans('xe::save'))
    );
    if (!parentId) {
      btns.prepend(
        $('<button>').attr('type', 'button').addClass('btn btn-default').text('닫기').click(function () {
          $(this).closest('.open').removeClass('open');
        })
      );
    }

    $('<div>').addClass('panel-footer').append(btns).appendTo($form);

    if (parentId) {
      $('<input>').attr({ type: 'hidden', name: 'parentId' }).val(parentId).appendTo($form);
    }

    return $form;
  },

  _edit: function (data) {
    var $form = $('<form>');

    $('<input>').attr({ type: 'hidden', name: 'id' }).val(data.id).appendTo($form);

    $('<div>').addClass('panel-heading').append(
      $('<div>').addClass('pull-left').append(
        $('<strong>').addClass('panel-title').text(XE.Lang.trans('xe::edit'))
      )
    ).appendTo($form);

    $('<div>').addClass('panel-body').append(
      $('<div>').addClass('form-group')
        .append($('<label>').text(XE.Lang.trans('xe::word')))
        .append(
          $('<div>').addClass('lang-editor-box').data({
          name: 'word',
          'lang-key': data.word,
          autocomplete: false,
        })
        )
    ).append(
      $('<div>').addClass('form-group')
        .append($('<label>').text(XE.Lang.trans('xe::description')))
        .append(
          $('<div>').addClass('lang-editor-box').data({
          name: 'description',
          'lang-key': data.description,
          multiline: true,
          autocomplete: false,
        })
        )
    ).appendTo($form);

    $('<div>').addClass('panel-footer').append(
      $('<div>').addClass('pull-right').append(
        $('<button>').attr('type', 'button').addClass('btn btn-default __xe_btn_remove').text('삭제')
      ).append(
        $('<button>').attr('type', 'submit').addClass('btn btn-primary').text(XE.Lang.trans('xe::save'))
      )
    ).appendTo($form);

    return $form;
  },
};

window.categoryTree = categoryTree;

return categoryTree;
})(typeof window !== 'undefined' ? window : this, jQuery, XE);
