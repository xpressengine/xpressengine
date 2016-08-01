;(function(exports) {
    'use strict';

    exports.WidgetBox = (function() {
        var self = this;

        return {
            init: function() {
                self = this;

                self.cache();
                self.bindEvents();

                return this;
            },
            cache: function() {
                self.$editor = $(".editor");
            },
            bindEvents: function() {
                self.$editor.on("click", "div[class^='xe-col-']:not(:has(> .widget))", self.selectColumn);
                self.$editor.on("click", ".btnWidgetConfig", self.openConfig);
                self.$editor.on("click", ".btnDelWidget", self.delWidget);
            },
            selectColumn: function(e) {
                e.stopPropagation();

                $(".selected").removeClass("selected");
                $(this).toggleClass("selected");
            },
            setOrdering: function() {
                $(".widgetarea").find(".order").each(function(i, ele) {
                    $(ele).text(i);
                });
            },
            deselectAll: function() {
                $(".selected").removeClass("selected");
            },
            placeWidget: function() {
                var widgetCode = $("#widgetCode").val(), 
                    $widgetCode = $(widgetCode);

                var $selected = $(".selected");

                if($selected.length > 0) {
                    var title = $widgetCode.attr("title");

                    var widgetView = [
                        '<div class="xe-row">',
                            '<div class="xe-col-md-12">',
                                '<div class="xe-well widget">',
                                    '<strong>' + title + '</strong>',
                                    '<div class="xe-pull-right widget-config-btn">',
                                        '<a href="#" class="xe-btn xe-btn-link btnWidgetConfig"><i class="xi-cog"></i></a>',
                                        '<button type="button" class="xe-btn xe-btn-link btnDelWidget"><i class="xi-trash"></i></button>',
                                    '</div>',
                                '</div>',
                            '</div>',
                        '</div>'
                    ].join("\n");

                    $selected.find(".widgetarea").append(widgetView);

                    self.increaseBlockSize($selected);

                }else {
                    window.console.error("선택된 셀이 없음.");
                }

            },
            openConfig: function() {
                window.console.log("open config");
            },
            delWidget: function() {
                //$(this).closest(".widgetarea").find()
                $(this).closest(".xe-row").remove();

                self.reduceBlockSize($(this).closest("div[class^='xe-col-']"));
            },
            checkReducibleSiblings: function($column) {
                var check = true;

                $(".editor > .xe-row").has($column).find(".widgetarea-row:last-child").not($column.parents(".xe-row")).not($column.closest(".widgetarea-row").siblings()).each(function() {
                    var $widgetarea = $(this).find(".widgetarea");
                    var widgetsCnt = $widgetarea.find(".widget").length;

                    // if(widgetsCnt > 0) {
                    //
                    // }

                });

                return check;
            },
            reduceBlockSize: function($column) {
                // if(self.checkReducibleSiblings($column)) {
                //
                // }
            },
            increaseBlockSize: function($column) {

                var $widgetarea = $column.find(".widgetarea"),
                    widgetHeight = $widgetarea.find(".widget").parent().outerHeight(),
                    widgetCnt = $widgetarea.find(".widget").length;

                //해당 박스에 위젯이 들어갈 공간이 없을 경우
                if($widgetarea.outerHeight() < widgetHeight * widgetCnt) {
                    var widgetareaHeight = $column.find(".widgetarea").outerHeight();
                    $column.find(".widgetarea").height((widgetareaHeight + 165)).data("height", (widgetareaHeight + 165));


                    $(".editor > .xe-row:has(.selected)").find(".widgetarea-row:last-child:not(:has(.selected))").not($(".selected").closest(".widgetarea-row").siblings()).each(function() {
                        var $widgetarea = $(this).find(".widgetarea");
                        var widgetareaHeight = $widgetarea.outerHeight();

                        $widgetarea.height(widgetareaHeight + 165).data("height", (widgetareaHeight + 165));
                    });
                }
            }
        };
    })();
})(window);