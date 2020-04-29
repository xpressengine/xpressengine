(function (exports, XE, $) {
  'use strict'

  var _cols = 12
  var _mode = 'md'

  /**
   * @returns {string}
   * @see https://stackoverflow.com/questions/105034/create-guid-uuid-in-javascript
   */
  function guid () {
    function s4 () {
      return Math.floor((1 + Math.random()) * 0x10000)
        .toString(16)
        .substring(1)
    }
    return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4()
  }

  var Row = function () {
    this.uid = guid()
    this.cols = []
  }
  Row.prototype = {
    addCol: function (col) {
      col.parent = this
      this.cols.push(col)
    },
    removeCol: function (colUid) {
      this.cols = this.cols.filter(function (col) {
        return col.uid !== colUid
      })
    },
    render: function () {
      var html = ''
      $.each(this.cols, function (i, col) {
        html += col.render()
      })

      return [
        '<div class="wb-row" data-uid="' + this.uid + '">',
        this.getHeader(),
        html,
        '</div>'
      ].join('')
    },
    getHeader: function () {
      return [
        '<div class="wb-row-header">',
        '<span class="label label-danger">row</span>',
        '<div class="pull-right">',
        '<button type="button" class="btn btn-row-remove"><i class="glyphicon glyphicon-remove"></i></button>',
        '</div>',
        '</div>'
      ].join('')
    },
    toJSON: function () {
      return this.cols
    }
  }

  var Col = function (grid) {
    this.uid = guid()
    this.grid = grid
    this.rows = []
    this.widgets = []
    this.parent = null
  }
  Col.prototype = {
    addRow: function (row) {
      row.parent = this
      this.rows.push(row)
      this.widgets = []
    },
    removeRow: function (uid) {
      this.rows = this.rows.filter(function (row) {
        return row.uid !== uid
      })
    },
    addWidget: function (widget, index) {
      if (this.rows.length > 0) {
        return
      }
      widget.parent = this
      if (index !== parseInt(index)) {
        this.widgets.push(widget)
      } else {
        this.widgets.splice(index, 0, widget)
      }
    },
    removeWidget: function (uid) {
      this.widgets = this.widgets.filter(function (widget) {
        return widget.uid !== uid
      })
    },
    setGrid: function (mode, span) {
      this.grid[mode] = span
    },
    removeGrid: function (mode) {
      var self = this
      var temp = {}
      var keys = Object.keys(this.grid).filter(function (key) {
        return key !== mode
      })

      $.each(keys, function (i, k) {
        return temp[k] = self.grid[k]
      })

      if (!$.isEmptyObject(temp)) {
        this.grid = temp
      }
    },
    setParent: function (parent) {
      this.parent = parent
    },
    render: function () {
      var html = ''
      var isWidget = this.rows.length < 1
      var items = !isWidget ? this.rows : this.widgets

      $.each(items, function (i, item) {
        html += item.render()
      })

      return [
        '<div class="wb-col" data-uid="' + this.uid + '" style="width:' + (this.columnWidth() * this.getSpan()) + '%">',
        this.getHeader(),
        isWidget ? this.wrapWidget(html) : html,
        '</div>'
      ].join('')
    },
    columnWidth: function () {
      return 100 / _cols
    },
    getSpan: function () {
      var m = ['xs', 'sm', 'md', 'lg']
      if (this.grid.hasOwnProperty(_mode)) {
        return this.grid[_mode]
      }

      var index = false
      var i

      for (i = 0; i < m.length; i++) {
        if (m[i] === _mode) {
          index = i
          break
        }
      }

      for (i = index - 1; i >= 0; i--) {
        if (this.grid.hasOwnProperty(m[i])) {
          return this.grid[m[i]]
        }
      }

      for (i = index + 1; i < m.length; i++) {
        if (this.grid.hasOwnProperty(m[i])) {
          return this.grid[m[i]]
        }
      }

      return _cols
    },
    getHeader: function () {
      var lables = ''
      $.each(this.grid, function (m, s) {
        lables += this.getLabel(m, s)
      }.bind(this))
      return [
        '<div class="wb-col-header">',
        lables,
        '<div class="pull-right">',
        '<button type="button" class="btn btn-col-remove"><i class="glyphicon glyphicon-remove"></i></button>',
        '</div>',
        '</div>'
      ].join('')
    },
    getLabel: function (mode, span) {
      var l = { xs: 'primary', sm: 'success', md: 'info', lg: 'warning' }[mode] || 'default'
      return [
        '<span class="tag label label-' + l + '" data-mode="' + mode + '" data-span="' + span + '">',
        '<span>' + mode + ':' + span + '</span>',
        '<a class="btn-span-remove"><i class="remove glyphicon glyphicon-remove-sign glyphicon-white"></i></a>',
        '</span>'
      ].join('')
    },
    wrapWidget: function (content) {
      return '<div class="widgetarea">' + content + '</div>'
    },
    toJSON: function () {
      return {
        grid: this.grid,
        rows: this.rows,
        widgets: this.widgets
      }
    }
  }

  var Widget = function (data) {
    this.uid = guid()
    this.data = data
    this.parent = null
  }
  Widget.prototype = {
    render: function () {
      if (this.data['widgetName'] == undefined) {
        this.data['widgetName'] = ''
      }
      if (this.data['skinName'] == undefined) {
        this.data['skinName'] = ''
      }
      return [
        '<div class="xe-well widget" data-uid="' + this.uid + '">',
        '<strong>' + this.data['@attributes'].title + '</strong>',
        '<span class="widget-name">' + this.data['widgetName'] + '</span>',
        '<span class="skin-name">(' + this.data['skinName'] + ')</span>',
        '<div class="xe-pull-right widget-config-btn">',
        '<a href="#" class="xe-btn xe-btn-link btn-widget-config"><i class="xi-cog"></i></a>',
        '<button type="button" class="xe-btn xe-btn-link btn-remove-widget"><i class="xi-trash"></i></button>',
        '</div>',
        '</div>'
      ].join('\n')
    },
    toJSON: function () {
      return this.data
    }
  }

  /**
   * @namespace WidgetBox
   * */
  exports.WidgetBox = (function () {
    var _this
    var _options = {}
    var _rows = []
    var _flat = {}

    return {
      init: function (options) {
        _this = this

        _options = options

        _this.cache()
        _this.bindEvents()
        _this.loadContents()

        _this.setColSpanOpt()
        _this.disableColControls()
        _this.disableWidgetControls()

        return this
      },
      cache: function () {
        _this.$editor = $('.editor')
        _this.$presenter = $('#presenter')
        _this.$colControls = $('#col-controls')
        _this.$btnAddWidget = $('#btn-add-widget')
        _this.$btnPlaceWidget = $('#btn-place-widget')
        _this.$btnCloseLayer = $('#btn-close-layer')
        _this.$btnPreview = $('#btn-preview')
        _this.$btnSave = $('#btn-save')
      },
      bindEvents: function () {
        // change presenter
        _this.$presenter.change(function () {
          _cols = $(this).children(':selected').data('cols') || 12

          _this.render()
        })

        // change view mode
        $('button', '.mode-btns').click(function (e) {
          e.preventDefault()
          _mode = $(this).data('mode')

          $('button', '.mode-btns').removeClass('xe-btn-primary')
          $(this).addClass('xe-btn-primary')

          _this.render()
        })

        // add new row
        $('#btn-add-row').click(function () {
          _rows.push(_this.createRow())
          _this.render()
        })

        // select row or col
        _this.$editor.on('click', '.wb-row, .wb-col', function (e) {
          e.stopPropagation()

          _this.$editor.find('.selected').removeClass('selected')
          $(this).addClass('selected')

          var except

          if ($(this).is('.wb-row')) {
            except = 'opt'
            _this.disableWidgetControls()
          } else {
            if ($(this).is(':empty')) {
              _this.enableWidgetControls()
            } else if ($(this).find('>.widgetarea').length) {
              except = 'col'
              _this.enableWidgetControls()
            } else {
              // except = 'col';
              _this.disableWidgetControls()
            }
          }

          _this.enableColControls(except)
        })

        // add col, add opt
        _this.$colControls.find('button').click(function () {
          var control = $(this).data('control')
          var mode = $('select[data-type=mode]', _this.$colControls).val()
          var span = $('select[data-type=span]', _this.$colControls).val()
          var $selected = _this.$editor.find('.selected')

          if (!$selected.length || !_flat.hasOwnProperty($selected.data('uid'))) {
            return
          }

          if (control === 'col') {
            _this.addCol(_flat[$selected.data('uid')], mode, span)
          } else if (control === 'opt') {
            _this.addSpanOpt(_flat[$selected.data('uid')], mode, span)
          }
        })

        // remove span opt
        _this.$editor.on('click', '.btn-span-remove', function (e) {
          e.stopPropagation()

          var mode = $(this).closest('.label').data('mode')
          var $col = $(this).closest('.wb-col')

          if (!_flat.hasOwnProperty($col.data('uid'))) {
            return
          }

          _this.removeSpanOpt(_flat[$col.data('uid')], mode)
        })

        // remove col
        _this.$editor.on('click', '.btn-col-remove', function (e) {
          e.stopPropagation()

          var $col = $(this).closest('.wb-col')
          _this.removeCol($col.data('uid'))
        })

        // remove row
        _this.$editor.on('click', '.btn-row-remove', function (e) {
          e.stopPropagation()

          var $row = $(this).closest('.wb-row')
          _this.removeRow($row.data('uid'))
        })

        // remove widget
        _this.$editor.on('click', '.btn-remove-widget', function (e) {
          e.stopPropagation()

          var $widget = $(this).closest('.widget')
          _this.removeWidget($widget.data('uid'))
        })
        // open widget config
        _this.$editor.on('click', '.btn-widget-config', function (e) {
          e.stopPropagation()

          var $widget = $(this).closest('.widget')
          _this.$btnPlaceWidget.data('widget', $widget.data('uid'))

          $('#widgetGen').widgetGenerator().reset(JSON.stringify(_flat[$widget.data('uid')]), function () {
            _this.openWidgetLayer()
          })
        })

        // open widget layer
        _this.$btnAddWidget.click(function () {
          _this.$btnPlaceWidget.data('widget', null)

          _this.openWidgetLayer()
        })
        // close widget layer
        _this.$btnCloseLayer.click(function () {
          _this.closeWidgetLayer()
        })
        // add or update widget
        _this.$btnPlaceWidget.click(function () {
          var attr = {}
          var data = {}
          var inputs = $('#widgetGen').widgetGenerator('data')

          for (var i in inputs) {
            if (i.indexOf('@') === 0) {
              attr[i.substr(1)] = inputs[i]
            } else {
              data[i] = inputs[i]
            }
          }

          if (!attr['id'] || !attr['skin-id']) {
            XE.toast('error', '위젯과 스킨을 선택하세요')
            return
          }

          var widgetId = _this.$btnPlaceWidget.data('widget')

          if (!widgetId) {
            var $selected = _this.$editor.find('.selected')
            if (!$selected.length || !_flat.hasOwnProperty($selected.data('uid'))) {
              return
            }

            _this.addWidget(_flat[$selected.data('uid')], $.extend({}, data, { '@attributes': attr }))
          } else {
            _this.updateWidget(widgetId, $.extend({}, data, { '@attributes': attr }))
            _this.$btnPlaceWidget.data('widget', null)
          }

          _this.closeWidgetLayer()
        })

        $('#widgetGen').on('keydown', '.__xe_widget-title', function (e) {
          // form요소에서 input요소 하나만 있을경우 submit되는 이슈
          if (e.keyCode === 13) {
            return false
          }
        })

        // preview
        _this.$btnPreview.click(function () {
          if (window.opener) {
            XE.ajax({
              url: $(this).data('url'),
              type: 'post',
              dataType: 'json',
              data: {
                data: _this.toJSON(),
                presenter: _this.$presenter.val()
              },
              success: function (res) {
                var content = res.content

                if (content) {
                  window.opener.previewWidgetBox(_options.widgetboxId, content)
                }
              }
            })
          }
        })

        // save
        _this.$btnSave.click(function () {
          XE.ajax({
            url: $(this).data('url'),
            type: 'put',
            dataType: 'json',
            data: {
              data: _this.toJSON(),
              presenter: _this.$presenter.val()
            },
            success: function (json) {
              XE.toast(json.type, json.message)

              if (window.opener) {
                window.opener.location.reload()
              }
            }
          })
        })
      },
      setColSpanOpt: function () {
        var $select = $('select[data-type=span]', _this.$colControls)
        $select.empty()
        for (var i = 1; i <= _cols; i++) {
          $('<option>').val(i).text(i).appendTo($select)
        }
      },
      enableColControls: function (except) {
        $('select, button', _this.$colControls).prop('disabled', false)
        if (except) {
          $('[data-control="' + except + '"]', _this.$colControls).prop('disabled', true)
        }
      },
      disableColControls: function () {
        $('select, button', _this.$colControls).prop('disabled', true)
      },
      enableWidgetControls: function () {
        _this.$btnAddWidget.prop('disabled', false)
      },
      disableWidgetControls: function () {
        _this.$btnAddWidget.prop('disabled', true)
      },
      loadContents: function () {
        XE.ajax({
          url: _options.loadUrl,
          type: 'get',
          dataType: 'json',
          success: function (json) {
            json.data = json.data || []
            var rows = []
            $.each(json.data, function (i, row) {
              rows.push(_this.createRow(row))
            })

            _rows = rows

            _this.$presenter.val(json.presenter).triggerHandler('change')
            // _this.render();
          }
        })
      },
      createRow: function (data) {
        var row = new Row()
        data = data || []

        $.each(data, function (i, col) {
          row.addCol(_this.createCol(col))
        })

        _flat[row.uid] = row

        return row
      },
      createCol: function (data) {
        var col = new Col(data.grid)

        data.rows = data.rows || []
        data.widgets = data.widgets || []

        if (data.rows.length) {
          $.each(data.rows, function (i, row) {
            col.addRow(_this.createRow(row))
          })
        } else {
          $.each(data.widgets, function (i, widget) {
            col.addWidget(_this.createWidget(widget))
          })
        }

        _flat[col.uid] = col

        return col
      },
      createWidget: function (data) {
        var widget = new Widget(data)

        _flat[widget.uid] = widget

        return widget
      },
      render: function () {
        var html = ''

        $.each(_rows, function (i, row) {
          html += row.render()
        })

        var selectedUid = _this.$editor.find('.selected').data('uid')

        _this.$editor.html(html)

        _this.$editor.find('[data-uid="' + selectedUid + '"]').addClass('selected')

        _this.bindSortable()
      },
      bindSortable: function () {
        $('.widgetarea', _this.$editor).sortable({
          opacity: 0.5,
          connectWith: '.widgetarea',
          placeholder: 'drop-placeholder',
          stop: function (e, ui) {
            var $item = ui.item
            var widget = _flat[$item.data('uid')]
            widget.parent.removeWidget(widget.uid)
            var colUid = $item.closest('.wb-col').data('uid')

            _flat[colUid].addWidget(widget, $item.parent().children().index($item))

            _this.render()
          }
        }).disableSelection()
      },
      addCol: function (target, mode, span) {
        var data = { grid: {} }
        data.grid[mode] = span

        if (target instanceof Col) {
          if (target.widgets.length) {
            return
          }

          if (!target.rows.length) {
            var row = _this.createRow()
            target.addRow(row)
            target = row
          } else {
            target = target.rows[0]
          }
        }

        if (!(target instanceof Row)) {
          return
        }

        target.addCol(_this.createCol(data))

        _this.render()
      },
      addSpanOpt: function (col, mode, span) {
        if (!(col instanceof Col)) {
          return
        }
        col.setGrid(mode, span)

        _this.render()
      },
      removeSpanOpt: function (col, mode) {
        if (!(col instanceof Col)) {
          return
        }
        col.removeGrid(mode)

        _this.render()
      },
      removeRow: function (uid) {
        if (_flat[uid].parent) {
          _flat[uid].parent.removeRow(uid)
        } else {
          _rows = _rows.filter(function (row) {
            return row.uid !== uid
          })
        }

        delete _flat[uid]

        _this.render()
      },
      removeCol: function (uid) {
        _flat[uid].parent.removeCol(uid)
        delete _flat[uid]

        _this.render()
      },
      addWidget: function (col, data) {
        col.addWidget(_this.createWidget(data))

        _this.render()
      },
      removeWidget: function (uid) {
        _flat[uid].parent.removeWidget(uid)
        delete _flat[uid]

        _this.render()
      },
      updateWidget: function (uid, data) {
        var widget = _flat[uid]

        widget.data = data

        _this.render()
      },
      openWidgetLayer: function () {
        $('.widget-layer').addClass('open')
        $('.dimd').show()
        $('body').css('overflow', 'hidden')
      },
      closeWidgetLayer: function () {
        $('.widget-layer').removeClass('open')
        $('.dimd').hide()
        $('body').css('overflow', '')

        // reset form
        $('.widget-form').empty()
        $('.__xe_select_widget').find('option:eq(0)').prop('selected', 'selected').trigger('change')
      },
      toJSON: function () {
        return JSON.stringify(_rows)
      }
    }
  })()
})(window, window.XE, window.jQuery)
