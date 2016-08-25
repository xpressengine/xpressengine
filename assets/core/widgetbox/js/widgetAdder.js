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
                            self.closeLayer();
                            self.placeWidget($("#widgetGen").widgetGenerator('code'));

                            $("#widgetGen").widgetGenerator('init');
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
            },
            placeWidget: function (widgetCode) {
                var $widgetCode = $(widgetCode);
                var $selected = $(".selected");
                var widgetCode = widgetCode.replace(/"/g, "'");

                if($selected.length > 0) {
                    var widgetId = $widgetCode.attr("id");
                    var widgetTitle = $widgetCode.attr("title");
                    var widgetView = [
                        '<div class="xe-row">',
                            '<div class="xe-col-md-12">',
                                '<div class="xe-well widget">',
                                    '<strong>' + widgetTitle + '</strong>',
                                    '<div class="xe-pull-right widget-config-btn">',
                                        '<input type="hidden" class="widgetCode" value="' + widgetCode + '" />',
                                        '<input type="hidden" class="widgetId" value="' + widgetId + '" />',
                                        '<input type="hidden" class="widgetTitle" value="' + widgetTitle + '" />',
                                        '<a href="#" class="xe-btn xe-btn-link btnWidgetConfig"><i class="xi-cog"></i></a>',
                                        '<button type="button" class="xe-btn xe-btn-link btnDelWidget"><i class="xi-trash"></i></button>',
                                    '</div>',
                                '</div>',
                            '</div>',
                        '</div>'
                    ].join("\n");

                    $selected.find(".widgetarea").append(widgetView);

                    WidgetBox.increaseBlockSize($selected);

                }else {
                    window.console.error("선택된 셀이 없음.");
                }

            }
        }
    })();
})(window, WidgetBox);