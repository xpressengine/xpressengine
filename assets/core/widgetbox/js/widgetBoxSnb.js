;(function(exports) {
    exports.WidgetSnb = (function() {
        var self;
        var _settings = {
            mode: 'desktop'
            , divisionType: '6|6'
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
                self.$selectDivision = $("#selectDivision");
                self.$btnDivision = $(".btnDivision");
            },
            bindEvents: function() {
                self.$btnMode.on("click", self.selectMode);
                self.$selectDivision.on("click", "li > a", self.selectDivisionType);
                self.$btnDivision.on('click', self.divide)
            },
            selectMode: function() {
                var $this = $(this)
                    , mode = $this.data("mode");

                _settings.mode = mode;
            },
            selectDivisionType: function() {
                _settings.divisionType = $(this).data("type");
            },
            divide: function() {
                var direction = $(this).data("type"); //horizontal or vertical

                switch(direction) {
                    case 'vertical' :
                        var columns = _settings.divisionType.split("|");

                        columns.forEach(function(v, i) {
                            
                        });

                        break
                    case 'horizontal' :

                        break;
                }


            }

        }
    })();
})(window);