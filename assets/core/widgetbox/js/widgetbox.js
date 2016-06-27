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

                $(this).toggleClass("selected");
            }
        };
    })();
})(window);