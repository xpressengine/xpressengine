;(function(exports) {
    exports.WidgetBox = (function() {
        var self = this;

        return {
            init: function() {
                self = this;

                self.cache()
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
                var widgetCode = $("#widgetCode").val()
                    , $widgetCode = $(widgetCode);

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

                }else {
                    console.error("선택된 셀이 없음.");
                }

            },
            openConfig: function() {
                console.log("open config");
            },
            delWidget: function() {
                $(this).closest(".xe-row").remove();
            }
        };
    })();
})(window);