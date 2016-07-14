(function(exports, WidgetBox) {
    exports.WidgetAdder = (function() {
        var self;

        return {
            init: function() {
                self = this;

                self.cache();
                self.bindEvents();

                return this;
            },
            cache: function() {
                self.$btnPlaceWidget = $(".btnPlaceWidget");
                self.$btnCloseLayer = $(".btnCloseLayer");
            },
            bindEvents: function() {
                self.$btnPlaceWidget.on('click', function() {
                    self.closeLayer();
                    WidgetBox.placeWidget();
                });
                self.$btnCloseLayer.on('click', self.closeLayer);
            },
            closeLayer: function() {
                $(".widget-layer").removeClass("open");
                $(".dimd").hide();
                $("body").css("overflow", "");
            }
        }
    })();
})(window, WidgetBox);