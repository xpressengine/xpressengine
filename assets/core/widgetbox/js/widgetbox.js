;(function(exports) {
    'use strict';

    var _options = {};

    exports.WidgetBox = (function() {
        var self = this;

        return {
            init: function (options) {
                self = this;

                self.cache();
                self.bindEvents();
                self.loadContents();
                
                _options = options || {};

                return this;
            },
            cache: function () {
                self.$editor = $(".editor");
                self.$btnUpdatePage = $('.btnUpdatePage');
            },
            bindEvents: function () {
                self.$editor.on("click", "div[class^='xe-col-']:not(:has(> .widget))", self.selectColumn);
                self.$editor.on("click", ".btnWidgetConfig", self.openConfig);
                self.$editor.on("click", ".btnDelWidget", self.delWidget);
                self.$btnUpdatePage.on('click', self.updatePage);
            },
            loadContents: function () {
                console.log(_options.codeUrl);
                
                XE.ajax({
                    url: _options.codeUrl,
                    type: 'get',
                    dataType: 'html',
                    success: function (html) {
                        console.log(html);
                    }
                })
            },
            updatePage: function () {
                if(_options.updateUrl) {
                    XE.ajax({
                        url: _options.updateUrl,
                        type: 'put',
                        dataType: 'json',
                        data: {
                            content: self.$editor.html()
                        },
                        success: function () {
                            XE.toast('success', '저장되었습니다');
                        }
                    });
                }else {
                    console.error('update url이 없음');
                }
            },
            selectColumn: function (e) {
                e.stopPropagation();

                $(".selected").removeClass("selected");
                $(this).toggleClass("selected");
            },
            setOrdering: function () {
                $(".widgetarea").find(".order").each(function(i, ele) {
                    $(ele).text(i);
                });
            },
            deselectAll: function () {
                $(".selected").removeClass("selected");
            },
            openConfig: function () {
                var widgetCode = $(this).siblings('.widgetCode').val();

                $("#widgetGen").widgetGenerator().reset(widgetCode, function() {
                    WidgetSnb.toggleWidgetAddLayer();
                });
            },
            delWidget: function () {
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
            checkReducibleBlock: function ($column, $widget) {
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
            reduceBlockSize: function ($column) {
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
            increaseBlockSize: function ($column) {

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