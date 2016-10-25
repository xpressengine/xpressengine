(function(exports, WidgetBox) {

    'use strict';

    exports.WidgetAdder = (function() {
        var self;

        return {
            init: function () {
                self = this;

                self.cache();
                self.bindEvents();

                return this;
            },
            cache: function () {
                self.$btnPlaceWidget = $(".btnPlaceWidget");
                self.$btnCloseLayer = $(".btnCloseLayer");
            },
            bindEvents: function () {
                self.$btnPlaceWidget.on('click', function() {
                    $("#widgetGen").widgetGenerator().generate(function() {
                        if($(".__xe_widget_code").val() !== '') {
                            self.placeWidget($("#widgetGen").widgetGenerator('code'));
                            self.closeLayer();

                        }else {
                            alert('위젯 코드가 생성되지 않았습니다.');
                        }
                    });
                });
                self.$btnCloseLayer.on('click', self.closeLayer);
            },
            closeLayer: function () {
                $(".widget-layer").removeClass("open");
                $(".dimd").hide();
                $("body").css("overflow", "");
                $("#widgetGen").widgetGenerator('init');
            },
            placeWidget: function (widgetCode) {
                var $widgetCode = $(widgetCode);
                var $selected = $(".selected");
                var widgetCode = widgetCode.replace(/"/g, "'");

                var widgetTitle = $widgetCode.attr("title");
                var widgetView = self.getWidgetBoxView(widgetCode, widgetTitle);

                //TODO 언어
                if(self.$btnPlaceWidget.text() === '수정') {
                    var index = self.$btnPlaceWidget.data('index');
                    $('.widget').eq(index).after(widgetView).remove();

                    self.$btnPlaceWidget.removeData('index');

                    $('.widget').eq(index).find('.widgetCode').val(widgetCode)
                    
                } else {
                    $selected.find(".widgetarea").append(widgetView).find('.widgetarea .widgetCode:last').val(widgetCode);

                }

                WidgetBox.increaseBlockSize($selected);
            },
            getWidgetBoxView: function(widgetCode, widgetTitle) {
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
                    '</div>'
                ].join("\n");
            }
        }
    })();
})(window, WidgetBox);
