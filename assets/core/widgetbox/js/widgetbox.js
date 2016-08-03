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
                var $column = $(this).parents(".widgetarea").closest("div[class^='xe-col-']");

                if(self.checkReducibleBlock($column, $(this).closest(".widget"))) {
                    self.reduceBlockSize($column);
                }

                $(this).closest(".xe-row").remove();
                
            },
            /**
             * @description
             * [1]클릭된 widget의 widgetarea 체크
             * [2]siblings 체크
             * */
            checkReducibleBlock: function($column, $widget) {
                var check = false;
                var widgetCnt = $column.find('.widget').length;
                var widgetareaHeight = $column.find(".widgetarea").outerHeight();
                var widgetHeight = $widget.parent().outerHeight();

                if ((widgetareaHeight - 165) >= 140 && (widgetareaHeight - ((widgetCnt - 1) * widgetHeight)) > 165) {
                    check = true;
                }

                if (check) {
                    $(".editor > .xe-row").has($column).find(".widgetarea-row:last-child").not($column.parents(".xe-row")).not($column.closest(".widgetarea-row").siblings()).each(function() {
                        var $widgetarea = $(this).find(".widgetarea");
                        var widgetsCnt = $widgetarea.find(".widget").length;

                        if(widgetsCnt > 0) {
                            var widgetareaHeight = $widgetarea.outerHeight();

                            if ((widgetareaHeight - 165) >= 140 && (widgetareaHeight - (widgetsCnt * widgetHeight)) > 165) {
                                check = true;

                            }else {
                                check = false;
                                return false;
                            }

                        }else {
                            if($widgetarea.outerHeight() > 140) {
                                check = true;

                            }else {
                                check = false;
                                return false;
                            }
                        }
                    });
                }

                console.log("check = ", check);

                return check;
            },
            reduceBlockSize: function($column) {
                var $widgetarea = $column.find(".widgetarea");
                var colWidgetHeight = $widgetarea.outerHeight();

                $widgetarea.height(colWidgetHeight - 165).data("height", colWidgetHeight - 165);

                $(".editor > .xe-row").has($column).find(".widgetarea-row:last-child").not($column.parents(".xe-row")).not($column.closest(".widgetarea-row").siblings()).each(function() {
                    var $this = $(this);
                    var $widgetarea = $this.find(".widgetarea"),
                        widgetareaHeight = $widgetarea.outerHeight();

                    $widgetarea.height(widgetareaHeight - 165).data("height", widgetareaHeight - 165);
                });
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