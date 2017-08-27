(function (exports, WidgetBox) {
'use strict';

/**
 * @namespace WidgetAddr
 * */
exports.WidgetAdder = (function () {
  var _this;

  return {
    /**
     * 위젯 설정페이지를 초기화한다.
     * @return {object}
     * @memberof WidgetAddr
     * */
    init: function () {
      _this = this;

      _this.cache();
      _this.bindEvents();

      return this;
    },
    /**
     * 위젯 설정페이지에서 사용되는 jquery element를 캐싱한다.
     * @memberof WidgetAddr
     * */
    cache: function () {
      _this.$btnPlaceWidget = $('.btnPlaceWidget');
      _this.$btnCloseLayer = $('.btnCloseLayer');
    },
    /**
     * 위젯 설정페이지에서 사용되는 이벤트를 정의한다.
     * @memberof WidgetAddr
     * */
    bindEvents: function () {
      _this.$btnPlaceWidget.on('click', function () {
        $('#widgetGen').widgetGenerator().generate(function () {
          if ($('.__xe_widget_code').val() !== '') {
            _this.placeWidget($('#widgetGen').widgetGenerator('code'));
            _this.closeLayer();

          } else {
            alert('위젯 코드가 생성되지 않았습니다.');
          }
        });
      });

      $('#widgetGen').on('keydown', '.__xe_widget-title', function (e) {

        //form요소에서 input요소 하나만 있을경우 submit되는 이슈
        if (e.keyCode === 13) {
          return false;
        }
      });

      _this.$btnCloseLayer.on('click', _this.closeLayer);
    },
    /**
     * 위젯 설정페이지를 닫는다.
     * @memberof WidgetAddr
     * */
    closeLayer: function () {
      $('.widget-layer').removeClass('open');
      $('.dimd').hide();
      $('body').css('overflow', '');
      $('#widgetGen').widgetGenerator('init');
    },
    /**
     * 설정된 위젯을 선택된 위젯박스에 위치한다.
     * @memberof WidgetAddr
     * @param {string} widgetCode
     * */
    placeWidget: function (widgetCode) {
      var $widgetCode = $(widgetCode);
      var $selected = $('.selected');
      var widgetCode = widgetCode.replace(/"/g, "'");

      var widgetTitle = $widgetCode.attr('title');
      var widgetView = _this.getWidgetBoxView(widgetCode, widgetTitle);

      //TODO 언어
      if (_this.$btnPlaceWidget.text() === '수정') {
        var index = _this.$btnPlaceWidget.data('index');
        $('.widget').eq(index).after(widgetView).remove();

        _this.$btnPlaceWidget.removeData('index');

        $('.widget').eq(index).find('.widgetCode').val(widgetCode);

      } else {
        $selected.find('.widgetarea').append(widgetView).find('.widgetCode:last').val(widgetCode);
      }

      WidgetBox.increaseBlockSize($selected);
    },
    /**
     * 위젯박스에 위치할 위젯 설정 템플릿을 리턴한다.
     * @memberof WidgetAddr
     * @param {string} widgetCode
     * @param {string} widgetTitle
     * @return {string}
     * */
    getWidgetBoxView: function (widgetCode, widgetTitle) {
      return [
        '<div class="xe-row">',
        '<div class="xe-col-md-12">',
        '<div class="xe-well widget">',
        '<strong>' + widgetTitle + '</strong>',
        '<div class="xe-pull-right widget-config-btn">',
        '<input type="hidden" class="widgetCode" value="' + widgetCode + '" />',
        '<a href="#" class="xe-btn xe-btn-link btnWidgetConfig"><i class="xi-cog"></i></a>',
        '<button type="button" class="xe-btn xe-btn-link btnDelWidget"><i class="xi-trash"></i></button>',
        '</div>',
        '</div>',
        '</div>',
        '</div>',
      ].join('\n');
    },
  };
})();
})(window, WidgetBox);
