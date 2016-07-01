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
                self.$editor.on("click", "div[class^='xe-col-']", self.selectColumn);
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
            }
        };
    })();
})(window);