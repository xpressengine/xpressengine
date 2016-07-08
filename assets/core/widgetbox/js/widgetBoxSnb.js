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


                    if($selectedParentRow.siblings().length > 0) {
                        var height = $selected.find(".widgetarea").data("height");
                        var lastColHeight = $selectedParentRow.siblings().last().find(".widgetarea").height();

                        if($selectedParentRow.parent().siblings().find("> .xe-row").length > 1) {
                            var $extendTarget = ($selectedParentRow.next().length > 0)? $selectedParentRow.next() : $selectedParentRow.prev()

                            $extendTarget.find(".widgetarea").height(lastColHeight + height + 25).data("height", lastColHeight + height + 25);
                            $selectedParentRow.remove();

                            return;
                        }else {

                            var $parentsCol = $();

                            while(true) {
                                $parentsCol = $selectedParentRow.closest("div[class^='xe-col-']");

                                if($parentsCol.length === 0) {
                                    $target = $selectedParentCol;
                                    break;
                                }else {
                                    if($parentsCol.siblings().length > 0) {
                                        $selectedParentRow.remove();
                                        $target = $parentsCol.siblings().andSelf();
                                        break;
                                    }else {
                                        $selectedParentRow = $selectedParentRow.closest(".xe-row");
                                        break;
                                    }
                                }
                            }

                            $selectedParentRow.remove();
                            $target = $target.siblings().andSelf();
                        }

                    }else {
                        $selectedParentRow.remove();
                    }

                    self.reduceBlock($target);
                    $("[reduce=true]").removeAttr("reduce");

                }else {
                    if($lastColumn.length > 0) {
                        var size = parseInt($selectedParentCol.attr('class').match(/col-md-([0-9]+)/i)[1]) + parseInt($lastColumn.attr('class').match(/col-md-([0-9]+)/i)[1]);

                        var $lastWidgetRow = $lastColumn.html();

                        $selectedParentCol.remove();
                        $lastColumn.removeAttr('class').addClass('xe-col-md-' + size);

                        if($($lastWidgetRow).wrap("div").parent().find("> .widgetarea-row").length > 0) {
                            var $lastColumnParentRow = $lastColumn.closest(".xe-row");

                            $lastColumnParentRow.parent().append($lastWidgetRow);
                            $lastColumnParentRow.remove();
                        }

                    }else {
                        var $target = $selectedParentRow.closest("div[class^='xe-col-']:not(.xe-col-md-12)").siblings();

                        $selectedParentRow.remove();

                        self.reduceBlock($target);
                        $("[reduce=true]").removeAttr("reduce");

                    }
                }

                WidgetBox.deselectAll();
                WidgetBox.setOrdering();
            },
            /**
             * TODO
             * @param {jquery element} $selected 선택된 column
             * @description
             * <pre>
             *     - 삭제 될수 있는 block인지 상, 하, 좌, 우 합쳐져야하는 요소인지 확인
             *     1)줄어들어야 하는 height 수치 필요 (상하 병합 되면서 수치가 늘어날수 있음)
             *     2)상위 dom으로 올라가며 확인
             * </pre>
             * @return {boolean} deletable
             * */
            checkBlock: function($selected) {
                var targetHeight = $selected.find(".widgetarea").data("height");
                var deletable = true;

                var $divCol = $selected.parent().closest("div[class^='xe-col-']:not(.xe-col-md-12)");

                while(true) { //상위 col-xx을 찾음 12가 아닌것
                    if($divCol.length > 0 && deletable) {
                        var $siblingCols = $divCol.siblings();

                        deletable = self.checkChildBlock($siblingCols, targetHeight);

                        $divCol = $divCol.parent().closest("div[class^='xe-col-']:not(.xe-col-md-12)");

                    }else {
                        break;
                    }
                }


                return deletable;

            },
            /**
             * TODO
             * @description 하위 dom을 내려가며 확인
             * */
            checkChildBlock: function($cols, targetHeight) {
                var deletable = true;

                $cols.each(function() {

                    var $sCol = $(this);

                    if($sCol.find("> .xe-row").length > 0) {
                        $sCol.find("> .xe-row").each(function() {

                            var $target = $(this).find("div[class^='xe-col-']:not(.xe-col-md-12)");

                            if($target.length === 0) {

                            }

                            deletable = self.checkChildBlock($target, targetHeight);

                            if(!deletable) {
                                return false;
                            }
                        });
                    }else {
                        //아래 로직이 최상위까지 돌아야됨
                        if($sCol.find("> .xe-row:last .widgetarea").data("height") <= targetHeight) {
                            //삭제 불가.

                            deletable = false;
                        }else {
                            //삭제될수 있음. 상위로 돌면서 확인

                            deletable = true;
                        }
                    }

                    if(!deletable) {
                        return false;
                    }

                });


                return deletable;
            },
            reduceBlock: function($target) {
                if($target.length > 0) {

                        $target.each(function() {
                        var $targetPiece = $(this);


                        //$targetPiece.find("> .widgetarea-row > div[class^='xe-col-'] > .widgetarea:last ").each(function() {


                        if($targetPiece.find("> .xe-row").length > 1) {
                            //$targetPiece.find("> .xe-row:last").find("> div[class^='xe-col-']")
                            console.log("row");

                        }else {
                            if($targetPiece.find("> .xe-row > div[class^='xe-col-'] > .widgetarea:last").length > 0) {
                                $targetPiece.find("> .xe-row > div[class^='xe-col-'] > .widgetarea:last").each(function() {
                                    var $widgetarea = $(this);

                                    if($widgetarea.data("height") > 140) {
                                        var height = $widgetarea.height() - 165;

                                        if (!$widgetarea.attr("reduce")) {
                                            $widgetarea.data("height", height).height(height).attr("reduce", true);
                                        }

                                    }
                                });
                            }else {
                                $target = $targetPiece.find("> .xe-row > div[class^='xe-col-']");
                            }

                        }

                    });

                    self.reduceBlock($target.parents("div[class^='xe-col-']").siblings());
                }
            }
        }
    })();
})(window, WidgetBox);