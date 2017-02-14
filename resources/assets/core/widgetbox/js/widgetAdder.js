(function (exports, WidgetBox) {
'use strict';

exports.WidgetAdder = (function () {
  var _this;

  return {
    init: function () {
      _this = this;

      _this.cache();
      _this.bindEvents();

      return this;
    },

    cache: function () {
      _this.$btnPlaceWidget = $('.btnPlaceWidget');
      _this.$btnCloseLayer = $('.btnCloseLayer');
    },

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

    closeLayer: function () {
      $('.widget-layer').removeClass('open');
      $('.dimd').hide();
      $('body').css('overflow', '');
      $('#widgetGen').widgetGenerator('init');
    },

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
