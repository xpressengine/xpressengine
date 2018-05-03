/**
 * <ul id='wrapper' data-infinite-url></ul>
 * @namespace XeInfinite
 * */
var XeInfinite = (function (XE, $) {
  /** @priavte */
  var _flag = false
  /** @priavte */
  var _this = this
  /** @priavte */
  var _defaultOptions = {
    editable: false,
    enableAddRow: true,
    enableColumnReorder: false,
    enableCellNavigation: false,
    rowHeight: 25,
    headerHeight: 0,
    showHeaderRow: false
  }

  return {
    /**
     * infinite grid를 초기화한다.
     * @memberof XeInfinite
     * @param {object} options
     * <pre>
     *   - wrapper {string} selector
     *   - template {string}
     *   - data {array}
     *   - loadRowCount {number} onGetRows를 호출하기전 체크. 스크롤시 남아있는 row의 갯수. loadRowCount갯수만큼 스크롤이 남을 경우 onGetRows를 호출한다.
     *   - rowHeight {number} row height
     *   - onGetRows {function} 스크롤중 데이터를 요청해야 할 경우 호출될 메소드.
     * </pre>
     * @param {object} customOptions slickgrid custom options
     * */
    init: function (options, customOptions) {
      _this = this

      if (!this.isValid(options)) {
        return false
      }

      this.loadResources(function () {
        _this.options = options
        _this.dataView = new Slick.Data.DataView()
        _this.columns = [{
          formatter: function (row, cell, value, columnDef, dataContext) {
            var template = options.template

            for (var prop in dataContext) {
              template = template.replace(new RegExp('{{' + prop + '}}', 'g'), dataContext[prop])
            }

            return template
          }
        }]

        if (options.hasOwnProperty('rowHeight')) {
          _defaultOptions.rowHeight = options.rowHeight
        }

        var defaultOptions = $.extend({}, _defaultOptions, customOptions || {})
        // $(".xe-list-group").css("height", "365px");

        _this.grid = new Slick.Grid(options.wrapper, _this.dataView, _this.columns, defaultOptions)
        _this.grid.setHeaderRowVisibility(false)

        $('.slick-header').hide()

        if (options.hasOwnProperty('data') &&
          options.data instanceof Array &&
          options.data.length > 0) {
          _this.bindEvents(options)
          _this.dataView.setItems(options.data)
        } else {
          _this.getRows()
          _this.bindEvents(options)
        }
      })

      return this
    },
    /**
     * 필수 옵션에 대한 유효성 체크를 실행한다.
     * @memberof XeInfinite
     * @param {object} options
     * <pre>
     *   - wrapper
     *   - template
     *   - onGetRows
     * </pre>
     * */
    isValid: function (options) {
      if (!options.hasOwnProperty('wrapper')) {
        console.error('XeInfinite::wrapper selector 정의가 없습니다.')
        return false
      }

      if (!options.hasOwnProperty('template')) {
        console.error('XeInfinite::template 정의가 없습니다.')
        return false
      }

      if (!options.hasOwnProperty('onGetRows') || typeof options.onGetRows !== 'function') {
        console.error('XeInfinite::onGetRows 정의가 없습니다.')
        return false
      }

      return true
    },
    /**
     * infinite grid를 실행하기 위한 resources를 로드한다.
     * @memberof XeInfinite
     * @param {function} cb resources를 로드한 이후 실행될 callback
     * */
    loadResources: function (cb) {
      XE.DynamicLoadManager.cssLoad('/assets/core/xe-ui-component/slickgrid/slick.grid.css')
      XE.DynamicLoadManager.jsLoadMultiple([
        '/assets/vendor/jqueryui/jquery.event.drag-2.3.0.js',
        '/assets/core/xe-ui-component/slickgrid/slick.core.js',
        '/assets/core/xe-ui-component/slickgrid/slick.formatters.js',
        '/assets/core/xe-ui-component/slickgrid/slick.grid.js',
        '/assets/core/xe-ui-component/slickgrid/slick.dataview.js'
      ], {
        complete: cb
      })
    },

    /**
     * 이벤트를 바인딩 한다.
     * @memberof XeInfinite
     * @param {object} options
     * */
    bindEvents: function (options) {
      _this.grid.onScroll.subscribe(function (e, args) {
        var $viewport = $('.slick-viewport')
        var loadRowCount = options.loadRowCount || 3

        if (!_flag && ($viewport[0].scrollHeight - $viewport.scrollTop()) < ($viewport.outerHeight() * loadRowCount)) {
          _this.getRows()
        }
      })

      _this.dataView.onRowCountChanged.subscribe(function (e, args) {
        _this.grid.updateRowCount()
        _this.grid.render()
      })

      _this.dataView.onRowsChanged.subscribe(function (e, args) {
        _this.grid.invalidateRows(args.rows)
        _this.grid.render()
      })
    },
    /**
     * init시 옵션으로 구현된 onGetRows를 호출한다.
     * @memberof XeInfinite
     * */
    getRows: function () {
      if (!_flag) {
        _this.options.onGetRows()
      }
    },
    /**
     * init시 옵션으로 구현된 addItem을 호출한다.
     * @memberof XeInfinite
     * @param {array} items
     * */
    addItems: function (items) {
      _this.dataView.addItem(items)
    },
    /**
     * onGetItems의 호출을 방지하는 flag를 설정한다.
     * @memberof XeInfinite
     * @param {boolean} flag onGetItems의 호출을 막는 flag
     * */
    setPrevent: function (flag) {
      _flag = flag
    }
  }
})(window.XE, window.jQuery)
