/**
 * <ul id='wrapper' data-infinite-url>
 * </ul>
 * */

var XeInfinite = (function () {
  var _flag = false;
  var _this = this;

  var _defaultOptions = {
    editable: false,
    enableAddRow: true,
    enableColumnReorder: false,
    enableCellNavigation: false,
    rowHeight: 25,
    headerHeight: 0,
    showHeaderRow: false,
  };

  return {
    /**
     * @param {object} options
     * <pre>
     *   wrapper {string} selector
		 *   template {string}
     *   data {array}
		 *   loadRowCount {number} 스크롤되는 요소의 row갯수
		 *   rowHeight {number} row height
		 *   onGetRows {function} 스크롤중 데이터를 요청해야 할 경우 호출될 메소드. 인자로 grid 객체를 넘겨준다.
     * </pre>
		 * @param {object} customOptions slickgrid custom options
     * */
    init: function (options, customOptions) {
      _this = this;

      if (!this.isValid(options)) {
        return false;
      }

      this.loadResources(function () {
        _this.options = options;
        _this.dataView = new Slick.Data.DataView();
        _this.columns = [{
          formatter: function (row, cell, value, columnDef, dataContext) {
            var template = options.template;

            for (var prop in dataContext) {
              template = template.replace(new RegExp('{{' + prop + '}}', 'g'), dataContext[prop]);
            }

            return template;
          },
        },];

        if (options.hasOwnProperty('rowHeight')) {
          _defaultOptions.rowHeight = options.rowHeight;
        }

        var defaultOptions = $.extend({}, _defaultOptions, customOptions || {});
        //$(".xe-list-group").css("height", "365px");

        _this.grid = new Slick.Grid(options.wrapper, _this.dataView, _this.columns, defaultOptions);
        _this.grid.setHeaderRowVisibility(false);

        $('.slick-header').hide();

        if (options.hasOwnProperty('data')
          && options.data instanceof Array
          && options.data.length > 0) {
          _this.bindEvents(options);
          _this.dataView.setItems(options.data);

        } else {
          _this.getRows();
          _this.bindEvents(options);
        }

      });

      return this;
    },

    isValid: function (options) {
      if (!options.hasOwnProperty('wrapper')) {
        console.error('XeInfinite::wrapper selector 정의가 없습니다.');
        return false;
      }

      if (!options.hasOwnProperty('template')) {
        console.error('XeInfinite::template 정의가 없습니다.');
        return false;
      }

      if (!options.hasOwnProperty('onGetRows') || typeof options.onGetRows !== 'function') {
        console.error('XeInfinite::onGetRows 정의가 없습니다.');
        return false;
      }

      return true;
    },

    loadResources: function (cb) {
      DynamicLoadManager.cssLoad('/assets/vendor/slickgrid/slick.grid.css');
      DynamicLoadManager.jsLoadMultiple([
        '/assets/vendor/jqueryui/jquery.event.drag-2.2.js',
        '/assets/vendor/slickgrid/slick.core.js',
        '/assets/vendor/slickgrid/slick.formatters.js',
        '/assets/vendor/slickgrid/slick.grid.js',
        '/assets/vendor/slickgrid/slick.dataview.js',
      ], {
        complete: cb,
      });
    },

    bindEvents: function (options) {

      _this.grid.onScroll.subscribe(function (e, args) {
        var $viewport = $('.slick-viewport');
        var loadRowCount = options.loadRowCount || 3;

        if (!_flag && ($viewport[0].scrollHeight - $viewport.scrollTop()) < ($viewport.outerHeight() * loadRowCount)) {
          _this.getRows();
        }

      });

      _this.dataView.onRowCountChanged.subscribe(function (e, args) {
        _this.grid.updateRowCount();
        _this.grid.render();
      });

      _this.dataView.onRowsChanged.subscribe(function (e, args) {
        _this.grid.invalidateRows(args.rows);
        _this.grid.render();
      });
    },

    getRows: function () {
      if (!_flag) {
        _this.options.onGetRows();
      }
    },

    addItems: function (items) {
      _this.dataView.addItem(items);
    },

    /**
     * @param {boolean} flag onGetItems의 호출을 막는 flag
     * @description flag를 통해 onGetItems의 호출을 방지
     * */
    setPrevent: function (flag) {
      _flag = flag;
    },
  };
})();
