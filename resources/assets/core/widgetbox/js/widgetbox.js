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

  var Container = function () {
    this.uid = guid()
    this.rows = []
    this.options = {}
  }
  Container.prototype = {
    addRow: function (row) {
      row.parent = this
      this.rows.push(row)
    },
    removeRow: function (rowUid) {
      this.rows = this.rows.filter(function (row) {
        return row.uid !== rowUid
      })
    },
    addOption: function (option) {
      this.options['fluid'] = true
    },
    removeOption: function (containerUid) {
      this.containers = this.containers.filter(function (container) {
        return container.uid !== containerUid
      })
    },
    setOptions: function (options) {
      this.options = options
    },
    render: function () {
      var html = ''
      $.each(this.rows, function (i, row) {
        html += row.render()
      })

      return [
        '<div class="wb-container" data-uid="' + this.uid + '">',
        this.getHeader(),
        html,
        '</div>'
      ].join('')
    },
    getHeader: function () {
      var _containerFluidLabel = this.options.fluid && ('<span class="label label-danger">' + 'container-fluid' + '</span>')

      return [
        '<div class="wb-container-header">',
        '<span class="label label-danger">container</span>',
        _containerFluidLabel,
        '<div class="pull-right">',
        '<button type="button" class="btn btn-container-remove"><i class="glyphicon glyphicon-remove"></i></button>',
        '</div>',
        '</div>'
      ].join('')
    },
    toJSON: function () {
      var _self = this;
      console.log(_self);
      console.log({
        rows: _self.rows,
        options: _self.options,
      })
      return {
        rows: _self.rows,
        options: _self.options,
      }
    }
  }

  var Row = function () {
    this.uid = guid()
    this.cols = []
    this.parent = null
    this.options = {}
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
    setOptions: function (options) {
      this.options = options
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
      var _activateColor = '';
      if (this.data['widgetName'] == undefined) {
        this.data['widgetName'] = ''
      }
      if (this.data['skinName'] == undefined) {
        this.data['skinName'] = ''
      }
      if (this.data['@attributes'].hasOwnProperty('activate') && this.data['@attributes'].activate == 'deactivate') {
        _activateColor = '#d0d0d0'
      }
      return [
        '<div class="xe-well widget" data-uid="' + this.uid + '" style=" background-color:' + _activateColor + '">',
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
    var _containers = []
    var _rows = []
    var _flat = {}
    var _supportContainer = null

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
        _this.$btnAddContainer = $('#btn-add-container')
      },
      bindEvents: function () {

        // tracking iframe dom
        _this.$editor.on('mouseover', '', function () {

        })


        // change presenter
        _this.$presenter.change(function (event, data) {
          _cols = $(this).children(':selected').data('cols') || 12
          if (!data) {
            XE.ajax({
              url: _this.$btnSave.data('url'),
              type: 'put',
              dataType: 'json',
              data: {
                data: _this.toJSON(),
                presenter: _this.$presenter.val()
              }
            }).then(function () {
              _this.loadContents()
              _this.setAvailableContainerBtn()
            })
          } else {
            _this.render()
          }
        })

        // change view mode
        $('button', '.mode-btns').click(function (e) {
          e.preventDefault()
          _mode = $(this).data('mode')

          $('button', '.mode-btns').removeClass('xe-btn-primary')
          $(this).addClass('xe-btn-primary')

          _this.render()
        })

        // add new container
        $('#btn-add-container').click(function () {
          _containers.push(_this.createContainer())
          _this.render()
        })

        // remove container event
        _this.$editor.on('click', '.btn-container-remove', function (e) {
          e.stopPropagation()

          var $container = $(this).closest('.wb-container')
          _this.removeContainer($container.data('uid'))
        })

        $('#btn-add-row').click(function () {
          if (_this._supportContainer) {
            var uid = _this.$editor.find('.selected').data('uid')
            var _container = _containers.find(function (container) {
              return container.uid == uid
            })
            _container.addRow(_this.createRow())
            _this.render()
          } else {
            _rows.push(_this.createRow())
            _this.render()
          }
        })

        // select row or col
        _this.$editor.on('click', '.wb-container, .wb-row, .wb-col', function (e) {
          e.stopPropagation()

          _this.$editor.find('.selected').removeClass('selected')
          $(this).addClass('selected')

          var except

          if ($(this).is('.wb-row')) {
            except = 'opt'
            _this.disableWidgetControls()
          } else if ($(this).is('.wb-container')) {
            except = 'container'
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
          var containerOpt = $('select[data-type=container]', _this.$colControls).val()

          var $selected = _this.$editor.find('.selected')

          if (!$selected.length || !_flat.hasOwnProperty($selected.data('uid'))) {
            return
          }

          if (control === 'col') {
            _this.addCol(_flat[$selected.data('uid')], mode, span)
          } else if (control === 'opt') {
            _this.addSpanOpt(_flat[$selected.data('uid')], mode, span)
          } else if (control === 'container') {
            _this.addOption(_flat[$selected.data('uid')], containerOpt)
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
          var _confirm = window.confirm('위젯을 삭제하시겠습니까?')
          var $widget = $(this).closest('.widget')

          if (_confirm) {
            _this.removeWidget($widget.data('uid'))
          }
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
          document.getElementById('preview').contentDocument.location.reload(true);
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
      setAvailableContainerBtn: function () {
        if (_this._supportContainer) {
          _this.$btnAddContainer.show()
        } else {
          _this.$btnAddContainer.hide()
        }
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
        if (except !== 'container') {
          $('[data-control="' + except + '"]', _this.$colControls).prop('disabled', true)
          $('[data-control="container"]', _this.$colControls).prop('disabled', true) // @FIXME
        } else {
          $('[data-control="' + except + '"]', _this.$colControls).prop('disabled', false)
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

        $('#preview').attr('src', document.referrer)

        XE.ajax({
          url: _options.loadUrl,
          type: 'get',
          dataType: 'json',
          success: function (json) {
            json.data = json.data || []

            if (_this._supportContainer == null) {
              _this.$presenter.val(json.presenter).triggerHandler('change', json)
            }
            _this._supportContainer = json.supportContainer
            _this.setAvailableContainerBtn()

            if (_this._supportContainer) {
              var containers = []
              $.each(json.data, function (i, container) {
                containers.push(_this.createContainer(container))
              })
              _containers = containers
              _this.$presenter.val(json.presenter).triggerHandler('change', json)
            } else {
              var rows = []
              $.each(json.data, function (i, row) {
                rows.push(_this.createRow(row))
              })
              _rows = rows
              _this.$presenter.val(json.presenter).triggerHandler('change', json)
            }
          }
        })
      },
      createContainer: function (data) {
        var container = new Container()
        data = data || []

        if (data.hasOwnProperty('options')) {
          container.setOptions(data.options)
        }
        if (data.hasOwnProperty('rows')) {
          data = data.rows
        }

        $.each(data, function (i, row) {
          container.addRow(_this.createRow(row))
        })

        _flat[container.uid] = container

        return container
      },

      createRow: function (data) {
        var row = new Row()
        data = data || []

        if (data.hasOwnProperty('options')) {
          row.setOptions(data.rows)
        }
        if (data.hasOwnProperty('cols')) {
          data = data.cols
        }

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

        if (_this._supportContainer) {
          $.each(_containers, function (i, container) {
            html += container.render()
          })
        } else {
          $.each(_rows, function (i, row) {
            html += row.render()
          })
        }

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
      addOption: function (container, option) {
        if (!(container instanceof Container)) {
          return
        }

        debugger;
        container.addOption(option)

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
      removeContainer: function (uid) {
        var _confirm = window.confirm('정말로 container를 삭제하시겠습니까?')
        if (!_confirm) return false

        if (_flat[uid].parent) {
          _flat[uid].parent.removeRow(uid)
        } else {
          _containers = _containers.filter(function (container) {
            return container.uid !== uid
          })
        }

        delete _flat[uid]

        _this.render()
      },
      removeRow: function (uid) {
        var _confirm = window.confirm('정말로 row를 삭제하시겠습니까?')
        if (!_confirm) return false

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
        var _confirm = window.confirm('정말로 col을 삭제하시겠습니까?')
        if (!_confirm) return false

        _flat[uid].parent.removeCol(uid)
        delete _flat[uid]

        _this.render()
      },
      addWidget: function (col, data) {
        col.addWidget(_this.createWidget(data))

        _this.render()
      },
      removeWidget: function (uid) {
        var _confirm = window.confirm('정말로 widget을 삭제하시겠습니까?')
        if (!_confirm) return false

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
        if (_this._supportContainer) {
          return JSON.stringify(_containers)
        } else {
          return JSON.stringify(_rows)
        }
      }
    }
  })()
})(window, window.XE, window.jQuery)
