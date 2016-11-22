(function ($) {
'use strict'

function Draft(elem, key, callback, withForm, container) {
  this.key = key;
  this.elem = elem;
  this.callback = callback;
  this.withForm = withForm;
  this.container = container;

  this.interval = null;

  this.draftId = null;
  this.component = null;

  this.uid = null;

  if (!$(this.elem).attr('name') || $(this.elem).attr('name') == '') {
    console.error("Must set 'name' attribute ");
    return;
  }

  this.init();

  return this;
}

Draft.prototype = {
  init: function () {
    this.uid = this._getUid();

    var _this = this;
    $(this.elem).on('input.draft', function () {
      _this.saveEventHandler();
    });

    this.appendComponent();
  },

  _getUid: function () {
    return Math.random().toString(36).substring(2, 15) +
      Math.random().toString(36).substring(2, 15);
  },

  toggle: function () {
    this.component.toggle();
  },

  appendComponent: function () {

    var _this = this;

    var onApply = function (data) {
      _this.setId(data.id);

      var values = data.etc;
      values[$(_this.elem).attr('name')] = data.val;

      dataSetter.init($(_this.elem).closest('form')[0], values);
      _this.callback(values);
    };

    var onRemove = function (data) {
      _this.reqDelete(data.id);
    };

    var $container = $('<div>');
    var config = { keyVal: this.key, onApply: onApply, onRemove: onRemove };
    var callback = function () {
      _this.component = this;
    };

    if ($(this.container).length < 1) {
      $(this.elem).closest('form').after($container);
      ReactDOM.render(React.createElement(DraftReact.Modal, config), $container[0], callback);
    } else {
      var collapseClass = this._collapseClass();
      $container.addClass([collapseClass, 'collapse'].join(' '));
      $(this.container).addClass([collapseClass, 'collapse', 'in'].join(' ')).after($container);
      ReactDOM.render(React.createElement(DraftReact.Collapse, $.extend(config, { collapseClass: collapseClass })), $container[0], callback);
    }
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
      url: xeBaseURL + '/draft/store',
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
      url: xeBaseURL + '/draft/update/' + this.draftId,
      type: 'post',
      dataType: 'json',
      data: this.getReqSerialize(),
      success: function (json) {
        if (json.draftId === null) {
          this.unsetId();
        }
      }.bind(this),
    });
  },

  setAuto: function () {
    $.ajax({
      url: xeBaseURL + '/draft/setAuto',
      type: 'post',
      data: this.getReqSerialize() + '&key=' + this.key,
    });
  },

  deleteAuto: function () {
    $.ajax({
      url: xeBaseURL + '/draft/destroyAuto',
      type: 'post',
      data: 'key=' + this.key,
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

  reqDelete: function (id) {
    id = id || this.draftId;

    if (!id) {
      return;
    }

    if (id == this.draftId) {
      this.draftId = null;
    }

    $.ajax({
      url: xeBaseURL + '/draft/destroy/' + id,
      type: 'post',
      dataType: 'json',
    });
  },

  setId: function (id) {
    this.draftId = id;
  },

  unsetId: function () {
    this.draftId = null;
  },
};

var DraftReact = {
  mixin: {
    getInitialState: function () {
      return {
        loaded: false,
        items: [],
      };
    },

    onRemove: function (data) {
      this.props.onRemove(data);
    },

    load: function () {
      this.setState({ loaded: false });

      $.ajax({
        url: xeBaseURL + '/draft',
        type: 'get',
        dataType: 'json',
        data: { key: this.props.keyVal },
        success: function (json) {
          this.setState({ loaded: true, items: json });
        }.bind(this),
      });
    },

    getItems: function () {
      return this.state.items.map(function (item, i) {
        return React.createElement(DraftReact.Item, {
          key: item.id,
          data: item,
          onApply: this.onApply,
          onRemove: this.onRemove,
        });
      }.bind(this));
    },
  },
};

DraftReact.Modal = React.createClass({

  mixins: [DraftReact.mixin],

  toggle: function () {
    $(ReactDOM.findDOMNode(this)).modal('toggle');
  },

  onApply: function (data) {
    this.props.onApply(data);
    $(ReactDOM.findDOMNode(this)).modal('hide');
  },

  componentDidMount: function () {
    var _this = this;
    $(ReactDOM.findDOMNode(this)).on('show.bs.modal', function () {
      _this.load();
    });
  },

  render: function () {

    return (
      React.DOM.div({ className: 'modal fade', role: 'dialog', 'aria-hidden': 'true' },
        React.DOM.div({ className: 'modal-dialog' },
          React.DOM.div({ className: 'modal-content' },
            React.DOM.div({ className: 'modal-header' },
              React.DOM.button({
                type: 'button',
                className: 'close',
                'data-dismiss': 'modal',
                'aria-label': 'Close',
              },
                React.DOM.span({
                'aria-hidden': 'true',
                dangerouslySetInnerHTML: { __html: '&times;' },
              })
              ),
              React.DOM.h4({ className: 'modal-title' }, 'Draft')
            ),
            React.DOM.div({ className: 'modal-body' },
              (function () {
                if (this.state.loaded !== true) {
                  return React.DOM.div({ className: 'text-center' },
                    React.DOM.i({ className: 'xi-spinner-1 xi-spin xi-4x' })
                  );
                } else {
                  return React.createElement(DraftReact.Box, { items: this.getItems() });
                }
              }.call(this))
            ),
            React.DOM.div({ className: 'modal-footer' },
              React.DOM.button({
              type: 'button',
              className: 'btn btn-default',
              'data-dismiss': 'modal',
            }, 'Close')
            )
          )
        )
      )
    );
  },
});

DraftReact.Collapse = React.createClass({

  mixins: [DraftReact.mixin],

  toggle: function () {
    $('.' + this.props.collapseClass).collapse('toggle');
  },

  onApply: function (data) {
    this.props.onApply(data);
    this.toggle();
  },

  componentDidMount: function () {
    var _this = this;
    $(ReactDOM.findDOMNode(this)).parent().on('show.bs.collapse', function () {
      _this.load();
    });
  },

  render: function () {
    return (
      React.DOM.div({ className: '' },
        React.DOM.div({ className: 'panel panel-default' },
          React.DOM.div({ className: 'panel-body' },
            (function () {
              if (this.state.loaded !== true) {
                return React.DOM.div({ className: 'text-center' },
                  React.DOM.i({ className: 'xi-spinner-1 xi-spin xi-4x' })
                );
              } else {
                return React.createElement(DraftReact.Box, { items: this.getItems() });
              }
            }.call(this))
          )
        )
      )
    );
  },
});

DraftReact.Box = React.createClass({

  render: function () {
    return (
      React.DOM.div({ className: 'draft_save_list' },
        React.DOM.ul(null, this.props.items)
      )
    );
  },
});

DraftReact.Item = React.createClass({
  getInitialState: function () {
    return {
      removed: false,
    };
  },

  onApply: function (e) {
    e.preventDefault();

    this.props.onApply(this.props.data);
  },

  onRemove: function (e) {
    e.preventDefault();

    this.setState({ removed: true });
    this.props.onRemove(this.props.data);
  },

  getDate: function () {
    return this.props.data.createdAt.substr(0, 16).replace(/-/g, ' ');
  },

  render: function () {
    if (this.state.removed === true) {
      return false;
    }

    return (
      React.DOM.li(null,
        React.DOM.a({ href: '#', className: 'draft_title', onClick: this.onApply },
          $($.parseHTML(this.props.data.val)).text()
        ),
        React.DOM.div({ className: 'draft_info' },
          (function () {
            if (this.props.data.isAuto == 1) {
              return React.DOM.span({ className: 'draft_state' }, XE.Lang.trans('xe::autoSave'));
            } else {
              return React.DOM.span({ className: 'draft_state v2' }, XE.Lang.trans('xe::draftSave'));
            }
          }.call(this)),
          React.DOM.span({ className: 'draft_date' }, this.getDate()),
          React.DOM.a({ href: '#', className: 'btn_draft_delete', onClick: this.onRemove },
            React.DOM.i({ className: 'xi-close' })
          )
        )
      )
    );
  },
});

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

  var draft = new Draft(this, args.key, args.callback, args.withForm, args.container);

  $(args.btnLoad).unbind('click.draft').bind('click.draft', function (e) {
    e.preventDefault();

    draft.toggle();
  });

  $(args.btnSave).unbind('click.draft').bind('click.draft', function (e) {
    e.preventDefault();

    draft.draftSet();
  });

  return draft;
};
})(jQuery);
