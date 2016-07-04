;(function(exports, WidgetBox) {
    exports.WidgetSnb = (function() {
        var self;
        var _settings = {
            mode: 'desktop'
            , divisionType: '6|6'
            , order: 0
        };

        return {
            init: function() {
                self = this;
                self.cache();
                self.bindEvents();

                return this;
            },
            cache: function() {
                self.$editor = $(".editor");
                self.$btnMode = $(".widget-snb .btnMode");
                self.$selectDivision = $("#selectDivision");
                self.$btnDivision = $(".btnDivision");
                self.$btnAddRow = $("#btnAddRow");
                self.$btnDeselectAll = $("#btnDeselectAll");
                self.$btnDelBlock = $("#btnDelBlock");
            },
            bindEvents: function() {
                self.$btnMode.on("click", self.selectMode);
                self.$selectDivision.on("click", "li > a", self.selectDivisionType);
                self.$btnDivision.on('click', self.divide)
                self.$btnAddRow.on('click', self.addRow);
                self.$btnDeselectAll.on("click", WidgetBox.deselectAll);
                self.$btnDelBlock.on("click", self.deleteBlock);
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
                var direction = $(this).data("direction"); //horizontal or vertical

                switch(direction) {
                    case 'vertical' :
                        var columns = _settings.divisionType.split("|")
                            , $selected = $(".selected")
                            , $target = $selected.closest(".widgetarea-row")
                            , html = "";

                        var height = $selected.data("height") || $selected.height();

                        $target.removeClass("widgetarea-row");
                        $selected.remove();

                        columns.forEach(function(v, i) {
                            html += [
                                '<div class="xe-col-md-' + v + '">',
                                    '<div class="xe-row widgetarea-row">',
                                        '<div class="xe-col-md-12">',
                                            '<div class="widgetarea" data-height="' + height + '" style="height:' + height + 'px">',
                                                '<span class="order"></span>',
                                            '</div>',
                                        '</div>',
                                    '</div>',
                                '</div>'
                            ].join("\n");
                        });

                        $target.html(html);

                        break;
                    case 'horizontal' :

                        var $selected = $(".selected")
                            , $widgetAreaRow = $selected.parents(".widgetarea-row");

                        $widgetAreaRow.after([
                            '<div class="xe-row widgetarea-row">',
                                '<div class="xe-col-md-12">',
                                    '<div class="widgetarea" data-height="140">',
                                        '<span class="order"></span>',
                                    '</div>',
                                '</div>',
                            '</div>',
                        ].join("\n"));

                        if($selected.height() > 140) {
                            var height = ($selected.height() - 25) / 2
                                , $wdigetareaRow = $selected.parents(".widgetarea-row")
                                , selectedHeight = $wdigetareaRow.find(".widgetarea").height();

                            $wdigetareaRow.find(".widgetarea").height(140).data("height", 140);

                            if((selectedHeight - 165) > 140) {
                                $wdigetareaRow.next().find(".widgetarea").height(selectedHeight - 165).data("height", selectedHeight - 165);
                            }else {
                                var height = $wdigetareaRow.next().find(".widgetarea").data("height");
                                $wdigetareaRow.next().find(".widgetarea").height(height).data("height", height);
                            }

                        }else {
                            var $cols = $widgetAreaRow.parents("div[class^='xe-col-']").siblings();

                            $cols.each(function() {
                                var $this = $(this);

                                $this.find(".widgetarea-row").parent().find(".widgetarea-row:last").each(function() {
                                    var $this = $(this);
                                    var height = $this.height() + 140;
                                    $this.find(".widgetarea:last").height(height).data("height", height);
                                });
                            });
                        }

                        break;

                    default:
                        console.error("type error.");
                }

                WidgetBox.deselectAll();
                WidgetBox.setOrdering();
            },
            addRow: function() {
                self.$editor.append([
                    '<div class="xe-row widgetarea-row">',
                        '<div class="xe-col-md-12">',
                            '<div class="widgetarea" data-height="140">',
                                '<span class="order"></span>',
                            '</div>',
                        '</div>',
                    '</div>'
                ].join("\n"));
            },
            deleteBlock: function() {
                var $selected = $(".selected");
                var $cols = $selected.parents(".widgetarea-row").parents("div[class^='xe-col-']");
                var $rowTarget = $cols.closest(".xe-row");

                // $cols.remove().promise().then(function() {
                //     $rowTarget.addClass(".widgetarea-row").append([
                //         '<div class="xe-row widgetarea-row">',
                //             '<div class="xe-col-md-12">',
                //                     '<div class="widgetarea" data-height="140">',
                //                     '<span class="order"></span>',
                //                 '</div>',
                //             '</div>',
                //         '</div>'
                //     ].split("\n"));
                // });
            }
        }
    })();
})(window, WidgetBox);