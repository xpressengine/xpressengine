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
                self.$divisionTypeView = $("#divisionTypeView");
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
                self.$btnDelBlock.on("click", self.removeBlock);
            },
            selectMode: function() {
                var $this = $(this)
                    , mode = $this.data("mode");

                _settings.mode = mode;
            },
            selectDivisionType: function() {
                var $this = $(this);

                self.$divisionTypeView.text($this.data("display"));

                _settings.divisionType = $this.data("type");

                self.divideVertical();
            },
            divide: function() {
                var direction = $(this).data("direction"); //horizontal or vertical

                switch(direction) {
                    case 'vertical' :
                        self.divideVertical();
                        break;

                    case 'horizontal' :
                        self.divideHorizontal();
                        break;

                    default:
                        console.error("type error.");
                }
            },
            divideVertical: function() {
                var columns = _settings.divisionType.split("|")
                    , $selected = $(".selected")
                    , $target = $selected.closest(".widgetarea-row")
                    , html = "";

                if($selected.length > 0) {
                    var height = $selected.find(".widgetarea").data("height") || $selected.find(".widgetarea").height();

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

                    WidgetBox.deselectAll();
                    WidgetBox.setOrdering();
                }
            },
            divideHorizontal: function() {
                var $selected = $(".selected")
                    , $widgetAreaRow = $selected.parents(".widgetarea-row");

                if($selected.length > 0) {
                    $widgetAreaRow.after([
                        '<div class="xe-row widgetarea-row">',
                            '<div class="xe-col-md-12">',
                                '<div class="widgetarea" data-height="140" style="height:140px">',
                                    '<span class="order"></span>',
                                '</div>',
                            '</div>',
                        '</div>',
                    ].join("\n"));

                    if($selected.find(".widgetarea").height() > 140) {
                        var height = ($selected.find(".widgetarea").height() - 25) / 2
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
                                var $this = $(this)
                                    , $lastTarget = $this.find(".widgetarea:last")
                                    , height = $lastTarget.data("height") + 165;

                                $lastTarget.height(height).data("height", height);
                            });
                        });
                    }

                    WidgetBox.deselectAll();
                    WidgetBox.setOrdering();
                }
            },
            addRow: function() {
                self.$editor.append([
                    '<div class="xe-row widgetarea-row">',
                        '<div class="xe-col-md-12">',
                            '<div class="widgetarea" data-height="140" style="height:140px">',
                                '<span class="order"></span>',
                            '</div>',
                        '</div>',
                    '</div>'
                ].join("\n"));
            },
            removeBlock: function() {

                var $selected = $(".selected")
                    , $selectedParentRow = $selected.parents(".widgetarea-row")
                    , $siblingsRow = $selectedParentRow.siblings()
                    , $selectedParentCol = $selectedParentRow.closest("div[class^='xe-col-']")
                    , $lastColumn = $selectedParentCol.siblings(":last");

                if($siblingsRow.length > 0) {
                    // var $expendTargetRow = $()
                    //     , height = $selectedParentRow.height();
                    //
                    // if($selectedParentRow.next().length > 0) {
                    //     $expendTargetRow = $selectedParentRow.next();
                    // }else {
                    //     $expendTargetRow = $selectedParentRow.prev();
                    // }
                    //
                    // height += $expendTargetRow.find("> div[class^='xe-col-'] .widgetarea").height();
                    //
                    // $selectedParentRow.remove();
                    // $expendTargetRow.find(".widgetarea").height(height).data("height", height);


                    //var $target = $selectedParentRow.parent().siblings().parents("div[class^='xe-col-']");
                    var $target = $selectedParentRow.parent().siblings();

                    $selectedParentRow.remove();

                    self.reduceBlock($target);
                    $("[reduce=true]").removeAttr("reduce");

                }else {
                    if($lastColumn.length > 0) {
                        var height = $selectedParentCol.find(".widgetarea").height()
                            , size = parseInt($selectedParentCol.attr('class').match(/col-md-([0-9]+)/i)[1]) + parseInt($lastColumn.attr('class').match(/col-md-([0-9]+)/i)[1]);

                        var $lastWidgetRow = $lastColumn.find(".widgetarea-row")

                        $selectedParentCol.remove();
                        $lastColumn.removeAttr('class').addClass('xe-col-md-' + size);

                        //TODO:: 수정 필요
                        if($lastWidgetRow.length > 0) {
                            var $lastColumnParentRow = $lastColumn.closest(".xe-row");

                            $lastColumnParentRow.parent().append($lastWidgetRow);
                            $lastColumnParentRow.remove();
                        }

                        // $lastColumn.removeAttr('class').addClass('xe-col-md-' + size).html([
                        //     '<div class="widgetarea" data-height="140" data-height="' + height + '" style="height:' + height + 'px">',
                        //         '<span class="order">0</span>',
                        //     '</div>'
                        // ].join("\n"));

                    }else {

                    }
                }

                WidgetBox.deselectAll();
                WidgetBox.setOrdering();
            },
            reduceBlock: function($target) {
                if($target.length > 0) {

                    $target.each(function() {
                        var $targetPiece = $(this);


                        $targetPiece.find("> .widgetarea-row > div[class^='xe-col-'] > .widgetarea:last ").each(function() {
                            var $widgetarea = $(this);

                            if($widgetarea.data("height") > 140) {
                                var height = $widgetarea.height() - 165;

                                if (!$widgetarea.attr("reduce")) {
                                    $widgetarea.data("height", height).height(height).attr("reduce", true);
                                }

                            }
                        });

                    });

                    self.reduceBlock($target.parents("div[class^='xe-col-']").siblings());
                }
            }
        }
    })();
})(window, WidgetBox);