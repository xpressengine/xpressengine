;(function(exports, WidgetBox) {
    exports.WidgetSnb = (function() {
        var self;
        var _settings = {
            mode: 'desktop'
            , divisionType: '6|6'
            , order: 0
        };
        var _deletable = true;

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
                self.$btnWidgetAdd = $(".btn-widget-add");
            },
            bindEvents: function() {
                self.$btnMode.on("click", self.selectMode);
                self.$selectDivision.on("click", "li > a", self.selectDivisionType);
                self.$btnDivision.on('click', self.divide)
                self.$btnAddRow.on('click', self.addRow);
                self.$btnDeselectAll.on("click", WidgetBox.deselectAll);
                self.$btnDelBlock.on("click", self.removeBlock);
                self.$btnWidgetAdd.on("click", self.toggleWidgetAddLayer);
            },
            toggleWidgetAddLayer: function() {
                // close sidebar
                if ($('.widget-layer').hasClass("open")) {
                    $("aside").removeClass("open");
                    // open sidebar
                } else {

                    if($(".selected").length > 0) {
                        $(".widget-layer").addClass("open");
                        $(".dimd").show();
                        $("body").css("overflow", "hidden");

                    }else {
                        alert("위젯을 추가할 셀을 선택하세요.");

                    }
                }
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
                    //var height = $selected.find(".widgetarea").data("height") || $selected.find(".widgetarea").height();
                    var height = $selected.find(".widgetarea").height();

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
                            //var height = $wdigetareaRow.next().find(".widgetarea").data("height");
                            var height = $wdigetareaRow.next().find(".widgetarea").height();
                            $wdigetareaRow.next().find(".widgetarea").height(height).data("height", height);
                        }

                    }else {
                        var $cols = $widgetAreaRow.parents("div[class^='xe-col-']").siblings();

                        $cols.each(function() {
                            var $this = $(this);

                            $this.find(".widgetarea-row").parent().find(".widgetarea-row:last").each(function() {
                                var $this = $(this)
                                    , $lastTarget = $this.find(".widgetarea:last")
                                    , height = $lastTarget.height() + 165;
                                //, height = $lastTarget.data("height") + 165;

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

                if(self.$editor.find(".widgetarea").length === 1) {
                    console.error("삭제될수 없음");
                    return;
                }

                if($siblingsRow.length > 0) {


                    var deletable = self.checkRowBlock($selected);
                    var $target = $();

                    if(deletable) {

                        var height = $selected.find(".widgetarea").height();
                        //var height = $selected.find(".widgetarea").data("height");
                        // var targetHeight = $selectedParentRow.siblings().last().find(".widgetarea").height();



                        $(".editor > .xe-row:has(.selected)").find(".widgetarea-row:last-child:not(:has(.selected))").not($(".selected").closest(".widgetarea-row").siblings()).each(function() {
                            var $lastWidgetareaRow = $(this)
                                , $widgetarea = $lastWidgetareaRow.find(".widgetarea")
                                , lastWidgetareaRowHeight = $widgetarea.height();

                            if(lastWidgetareaRowHeight > height) {
                                var resetHeight = lastWidgetareaRowHeight - height - 25;

                                $widgetarea.height(resetHeight).data("height", resetHeight);
                            }
                        });

                        $selectedParentRow.remove();

                        // if($selectedParentRow.parent().siblings().find("> .xe-row").length > 1) {
                        //     var $combineRow = ($selectedParentRow.next().length > 0)? $selectedParentRow.next() : $selectedParentRow.prev();
                        //
                        //     ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        //
                        //     // if($combineRow.find(".widgetarea-row:last-child").length > 0 && deletable) {
                        //     //     //가장 하위의 bottom DOM을 선택
                        //     //     $combineRow.find(".widgetarea-row:last-child .widgetarea").each(function() {
                        //     //         var $widgetarea = $(this)
                        //     //             , widgetareaHeight = $widgetarea.data("height")
                        //     //             , resetHeight = widgetareaHeight + targetHeight + 25;
                        //     //
                        //     //         $widgetarea.height(resetHeight).data("height", resetHeight);
                        //     //     });
                        //     // }else {
                        //     //     //$combineRow가 .widgetarea-row 일때
                        //     //     var $widgetarea = $combineRow.find(".widgetarea")
                        //     //         , widgetareaHeight = $widgetarea.data("height")
                        //     //         , resetHeight = widgetareaHeight + targetHeight + 25;
                        //     //
                        //     //     $widgetarea.height(resetHeight).data("height", resetHeight);
                        //     // }
                        //
                        //     $selectedParentRow.remove();
                        //
                        //     return;
                        //     ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        //
                        // }else {
                        //
                        //     var $parentsCol = $();
                        //
                        //     while(true) {
                        //         $parentsCol = $selectedParentRow.closest("div[class^='xe-col-']");
                        //
                        //         if($parentsCol.length === 0) {
                        //             $target = $selectedParentCol;
                        //             break;
                        //         }else {
                        //             if($parentsCol.siblings().length > 0) {
                        //                 $selectedParentRow.remove();
                        //                 $target = $parentsCol.siblings().andSelf();
                        //                 break;
                        //             }else {
                        //                 $selectedParentRow = $selectedParentRow.closest(".xe-row");
                        //                 break;
                        //             }
                        //         }
                        //     }
                        //
                        //     $selectedParentRow.remove();
                        //     $target = $target.siblings().andSelf();
                        // }
                        //
                        // self.reduceBlock($target);
                        // $("[reduce=true]").removeAttr("reduce");

                    }else {

                        //주변의 블럭과 합쳐줘야함.
                        /**
                         * 1)next확인
                         * 2)prev확인
                         * 3)row, col 확인
                         * 4)row라면 last row에 있는 컬럽을 늘림
                         * 5)col이라면 col하위의 last row의 col을 늘림
                         * */
                        //var targetHeight = $selected.find(".widgetarea").data("height");
                        var targetHeight = $selected.find(".widgetarea").height();

                        if($selectedParentRow.siblings().length > 0) {
                            var $combineRow = ($selectedParentRow.next().length > 0)? $selectedParentRow.next() : $selectedParentRow.prev();

                            // $combineRow.find(".widgetarea-row .widgetarea").each(function() {
                            //     var $widgetarea = $(this)
                            //         , widgetareaHeight = $widgetarea.data("height");
                            //
                            //
                            //     var resetHeight = widgetareaHeight + targetHeight + 25;
                            //
                            //     $widgetarea.data("height", resetHeight).height(resetHeight);
                            // });

                            $selectedParentRow.remove();

                            if($combineRow.find(".widgetarea-row:last-child").length > 0 && deletable) {
                                //가장 하위의 bottom DOM을 선택
                                $combineRow.find(".widgetarea-row:last-child .widgetarea").each(function() {
                                    var $widgetarea = $(this)
                                        , widgetareaHeight = $widgetarea.height()
                                    // , widgetareaHeight = $widgetarea.data("height")
                                        , resetHeight = widgetareaHeight + targetHeight + 25;

                                    $widgetarea.height(resetHeight).data("height", resetHeight);
                                });
                            }else {
                                //$combineRow가 .widgetarea-row 일때
                                var $widgetarea = $combineRow.find(".widgetarea")
                                //, widgetareaHeight = $widgetarea.data("height")
                                    , widgetareaHeight = $widgetarea.height()
                                    , resetHeight = widgetareaHeight + targetHeight + 25;

                                $widgetarea.height(resetHeight).data("height", resetHeight);
                            }


                            // var $findCol = ($combineRow.find("div[class^='xe-col-']:not(.xe-col-md-12)").length > 0)? $combineRow.find(".widgetarea-row") : $combineRow;
                            //
                            // $selectedParentRow.remove();
                            //
                            // $findCol.parent().each(function() {
                            //     $(this).find(".widgetarea-row:last .widgetarea").each(function() {
                            //         var $widgetarea = $(this)
                            //             , widgetareaHeight = $widgetarea.data("height");
                            //
                            //
                            //         var resetHeight = widgetareaHeight + targetHeight + 25;
                            //
                            //         $widgetarea.data("height", resetHeight).height(resetHeight);
                            //     });
                            // });

                        }else {
                            //없어야 정상
                            console.error("error 정의되지 않은 조건. ");
                        }
                    }

                }else {
                    if($selectedParentCol.siblings().length > 0) {
                        var size = parseInt($selectedParentCol.attr('class').match(/col-md-([0-9]+)/i)[1]) + parseInt($lastColumn.attr('class').match(/col-md-([0-9]+)/i)[1]);

                        //var $lastWidgetRow = $lastColumn.html();
                        var $siblingCol = ($selectedParentCol.next().length > 0)? $selectedParentCol.next() : $selectedParentCol.prev()
                            , siblingColHtml = $siblingCol.html();

                        $selectedParentCol.remove();
                        $siblingCol.removeAttr('class').addClass('xe-col-md-' + size);

                        //if($(siblingColHtml).wrap("div").parent().find("> .widgetarea-row").length > 0) {
                        //if($siblingCol.closest(".xe-row").parent().find("> .xe-row").length > 1 || $siblingCol.siblings().length === 0) {
                        if($siblingCol.siblings().length === 0) {
                            $siblingCol.closest(".xe-row").parent().append(siblingColHtml);
                            $siblingCol.closest(".xe-row").remove();
                        }


                        // if($(siblingColHtml).wrap("div").parent().find("> .widgetarea-row").length > 0) {
                        //     var $lastColumnParentRow = $lastColumn.closest(".xe-row");
                        //
                        //     $lastColumnParentRow.parent().append(siblingColHtml);
                        //     $lastColumnParentRow.remove();
                        // }

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
            checkRowBlock: function($selected) {
                //var targetHeight = $selected.find(".widgetarea").data("height");


                // var targetHeight = $selected.find(".widgetarea").height()
                // var deletable = true;
                //
                // $(".editor > .xe-row:has(.selected)")
                //     .find(".widgetarea-row:last-child:not(:has(.selected))")
                //     .not($selected.closest(".widgetarea-row").siblings()).each(function() {
                //
                //     var $row = $(this);
                //
                //     //if($row.find(".widgetarea").data("height") <= targetHeight) {
                //     if($row.find(".widgetarea").height() <= targetHeight) {
                //         deletable = false;
                //     }
                // });



                var targetHeight = $selected.find(".widgetarea").data("height");
                _deletable = true;

                var $divCol = $selected.parent().closest("div[class^='xe-col-']:not(.xe-col-md-12)");

                while(true) { //상위 col-xx을 찾음 12가 아닌것
                    if($divCol.length > 0 && _deletable) {
                        var $siblingCols = $divCol.siblings();




                        _deletable = self.checkRowChildBlock($siblingCols, targetHeight);

                        $divCol = $divCol.parent().closest("div[class^='xe-col-']:not(.xe-col-md-12)");

                    }else {
                        console.log("%c 최상위 col", "background:blue;color:#FFFFFF;font-weight:bold");
                        break;
                    }
                }


                console.log(":: deletable :: " + _deletable);

                return _deletable;

                // return deletable;

            },
            /**
             * TODO
             * @description 하위 dom을 내려가며 확인
             * */
            checkRowChildBlock: function($cols, targetHeight) {

                if(!_deletable) {
                    return false;
                }

                $cols.each(function() {

                    var $sCol = $(this);

                    if(!_deletable) {
                        return false;
                    }

                    if($sCol.find("> .xe-row").length > 0) {

                        var $lastRow = $sCol.find("> .xe-row:last");
                        var $target = $lastRow.find("> div[class^='xe-col-']:not(.xe-col-md-12)");

                        if($target.length === 0) {
                            $target = $lastRow.find(".xe-col-md-12");
                            // return self.checkChildBlock($target, targetHeight);
                        }

                        _deletable = self.checkRowChildBlock($target, targetHeight);

                        // $sCol.find("> .xe-row").each(function() {
                        //
                        //     var $target = $(this).find("> div[class^='xe-col-']:not(.xe-col-md-12)");
                        //
                        //     if(!_deletable) {
                        //         return false;
                        //     }
                        //
                        //     if($target.length === 0) {
                        //         $target = $(this).find(".xe-col-md-12");
                        //         // return self.checkChildBlock($target, targetHeight);
                        //     }
                        //
                        //     _deletable = self.checkChildBlock($target, targetHeight);
                        //
                        // });
                    }else {
                        //최하위 cols
                        //if($sCol.find(".widgetarea").data("height") <= targetHeight) {
                        if($sCol.find(".widgetarea").height() <= targetHeight) {
                            _deletable = false;
                            return false;
                        }

                        // //아래 로직이 최상위까지 돌아야됨
                        // if($sCol.find("> .xe-row:last .widgetarea").data("height") <= targetHeight) {
                        //     //삭제 불가.
                        //
                        //     _deletable = false;
                        // }else {
                        //     //삭제될수 있음. 상위로 돌면서 확인
                        //
                        //     _deletable = true;
                        // }
                    }

                });


                return _deletable;
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
                            if($targetPiece.find(".widgetarea-row:last-child:not(:has(.selected))").length > 0) {
//                                $targetPiece.find("> .xe-row > div[class^='xe-col-'] > .widgetarea:last").each(function() {
                                $targetPiece.find(".widgetarea-row:last-child:not(:has(.selected))").find(".widgetarea").each(function() {

                                    var $widgetarea = $(this);

                                    //if($widgetarea.data("height") > 140) {
                                    if($widgetarea.height() > 140) {
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