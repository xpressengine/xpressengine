;(function(exports) {
    exports.WidgetSnb = (function() {
        var self;
        var _settings = {
            mode: 'desktop'
        };

        return {
            init: function() {
                self = this;
                self.cache();
                self.bindEvents();

                return this;
            },
            cache: function() {
                self.$btnMode = $(".widget-snb .btnMode");
            },
            bindEvents: function() {
                self.$btnMode.on("click", self.selectMode);
            },
            selectMode: function() {
                var $this = $(this)
                    , mode = $this.data("mode");

                _settings.mode = mode;
            },

        }
    })();
})(window);