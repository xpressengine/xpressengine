;(function () {
  $.fn.setHeight = function (height) {
    this.height(height).data('height', height).attr('data-height', height);

    return this;
  };
})();

;(function (exports) {

  'use strict';

  var _options = {};

  /**
   * @namespace WidgetBox
   * */
  exports.WidgetBox = (function () {
    var _this = this;

    return {
      /**
       * 위젯박스 페이지를 초기화한다.
       * @memberof WidgetBox
       * @return {object}
       * */
      init: function (options) {
        _this = this;

        _options = options || {};

        _this.cache();
        _this.bindEvents();
        _this.loadContents();

        return this;
      },
      /**
       * 페이지에서 사용되는 jquery object를 캐싱한다.
       * @memberof WidgetBox
       * */
      cache: function () {
        _this.$editor = $('.editor');
        _this.$btnUpdatePage = $('.btnUpdatePage');
        _this.$btnPreview = $('.btnPreview');
      },
      /**
       * 페이지에서 사용되는 이벤트 핸들러를 정의한다.
       * @memberof WidgetBox
       * */
      bindEvents: function () {
        _this.$editor.on('click', "div[class^='xe-col-']:not(:has(> .xe-row)):not(:has(> .widget))", _this.selectColumn);
        _this.$editor.on('click', '.btnWidgetConfig', _this.openConfig);
        _this.$editor.on('click', '.btnDelWidget', _this.delWidget);
        _this.$editor.on('mouseenter', '.widgetarea', _this.addDragDropEvents);
        _this.$btnUpdatePage.on('click', _this.updatePage);
        _this.$btnPreview.on('click', _this.preview);
      },
      /**
       * 위젯을 셀에서 드래그 할때 코드를 정의.
       * @memberof WidgetBox
       * */
      addDragDropEvents: function () {

        $('.widgetarea:not(.ui-sortable)').sortable({
          opacity: 0.5,
          connectWith: '.widgetarea',
          items: '> .xe-row',
          change: function (e, ui) {
            var index = $('.dropzone').find('.xe-row.ui-sortable-handle').index(ui.placeholder);

            if (index >= 0) {
              _this.index = index;
            }

            // var width = ui.placeholder.width();

            // ui.item.width(width);
          },

          start: function () {

            $('.widgetarea:not(.ui-droppable)').parent().droppable({
              greety: true,
              tolerance: 'pointer',
              hoverClass: 'dropzone',
              over: function () {
                var $dropzone = $('.dropzone');
                var dropzoneLen = $dropzone.length;

                if (dropzoneLen > 1) {
                  $dropzone.not(':eq(0)').removeClass('dropzone');
                }
              },

              drop: function (e, ui) {
                var $this = $(this).eq(0);
                var $dropped = ui.draggable;
                var $widgetColumn = $dropped.closest('.widgetarea').parent();

                if (_this.$editor.find('.widgetarea').parent().index($widgetColumn) !== _this.$editor.find('.widgetarea').parent().index($this)) {
                  var $cloneEle = $dropped.clone().removeAttr('style');

                  _this.selectColumn.call($this, $.Event());

                  if (_this.checkReducibleBlock($widgetColumn, $dropped.find('.widget'))) {
                    _this.reduceBlockSize($widgetColumn);
                  }

                  if ($widgetColumn.find('.xe-row.ui-sortable-handle').length > 0) {
                    if (_this.index === 0) {
                      $this.find('.widgetarea').prepend($cloneEle);

                    } else {
                      if ($this.find('.widgetarea > .xe-row').length - 1 - _this.index >= 0) {
                        $this.find('.widgetarea').find('.xe-row.ui-sortable-handle').eq(_this.index).after($cloneEle);
                      } else {
                        $this.find('.widgetarea').append($cloneEle);
                      }
                    }

                  } else {
                    $this.find('.widgetarea').append($cloneEle);
                  }

                  $dropped.remove();

                  WidgetBox.increaseBlockSize($this);

                  _this.index = 0;
                }

              },
            });
          },
        }).disableSelection();

      },
      /**
       * 위젯 박스 페이지를 ajax로 요청한다.
       * @memberof WidgetBox
       * */
      loadContents: function () {
        XE.ajax({
          url: _options.codeUrl,
          type: 'get',
          dataType: 'json',
          success: function (html) {
            var code = html.code;
            var content = '';

            if (code) {
              var $content = $(code);
              var $xeWidgets = $content.find('xewidget');

              $content.find('[data-height]').each(function () {
                var $this = $(this);
                var height = $this.data('height');

                $this.height(height).data('height', height).attr('data-height', height);
              });

              $xeWidgets.each(function () {
                var $this = $(this);
                var $parent = $this.parent();
                var widgetCdoe = $this.wrap('<div />').parent().html().replace(/"/g, "'");
                var widgetTitle = $this.attr('title');
                var widgetView = WidgetAdder.getWidgetBoxView(widgetCdoe, widgetTitle);
                var $widgetView = $(widgetView).find('.xe-col-md-12 >');
                $widgetView.find('.widgetCode').val(widgetCdoe);
                $parent.html($widgetView);
              });

              $content.find('.widgetarea').each(function () {
                var $this = $(this);

                if ($this.find('>').length > 0) {
                  $('<span />', {
                    class: 'order',
                  }).insertBefore($this.find('>').eq(0));
                } else {
                  $this.html('<span class="order"></span>');
                }
              });

              content = $content;

            } else {
              content = [
               '<div class="xe-row widgetarea-row">',
               '<div class="xe-col-md-12">',
               '<div class="widgetarea" data-height="140" style="height:140px">',
               '<span class="order">0</span>',
               '</div>',
               '</div>',
               '</div>',
              ].join('\n');
            }

            _this.$editor.html(content);
            _this.setOrdering();
          },
        });
      },
      /**
       * 위젯박스 컨텐츠를 리턴한다.
       * @memberof WidgetBox
       * @return {string}
       * */
      getWidgetEditorContent: function () {
        return _this.$editor.html();
      },
      /**
       * 저장할 위젯 가공 컨텐츠를 리턴한다.
       * @memberof WidgetBox
       * @return {string}
       * */
      getWidgetEditorConvertContent: function () {
        var content = _this.getWidgetEditorContent();
        var $content = $(content);
        var $widgetCodes = $content.find('.widgetCode');

        $widgetCodes.each(function () {
          var $this = $(this);
          var widgetCode = $this.val();

          $this.closest('.xe-col-md-12').html(widgetCode);
        });

        $content.find('[style*="height"]').removeAttr('style');
        $content.find('.ui-sortable').removeClass('ui-sortable');
        $content.find('.ui-droppable').removeClass('ui-droppable');
        $content.find('.ui-sortable-handle').removeClass('ui-sortable-handle');
        $content.find('.ui-sortable-helper').removeClass('ui-sortable-helper');

        $content.find('.order').remove();

        content = $content.wrapAll('<div />').parent().html();

        return content;
      },
      /**
       * 위젯 페이지를 저장한다.
       * @memberof WidgetBox
       * */
      updatePage: function () {
        if (_options.updateUrl) {

          var content = _this.getWidgetEditorConvertContent();

          XE.ajax({
            url: _options.updateUrl,
            type: 'put',
            dataType: 'json',
            data: {
              content: content,
            },
            success: function () {
              XE.toast('success', '저장되었습니다');

              if (window.opener) {
                window.opener.location.reload();
              }
            },
          });
        } else {
          console.error('update url이 없음');
        }
      },
      /**
       * 미리보기를 실행한다.
       * @memberof WidgetBox
       * */
      preview: function () {
        if (window.opener) {
          var content = _this.getWidgetEditorConvertContent();

          XE.ajax({
            url: _options.previewUrl,
            type: 'post',
            dataType: 'json',
            data: {
              code: content,
            },
            success: function (res) {
              var content = res.content;

              if (content) {
                window.opener.previewWidgetBox(_options.widgetboxId, content);
              }
            },
          });
        }
      },
      /**
       * 선택한 셀을 표시한다.
       * @memberof WidgetBox
       * */
      selectColumn: function (e) {
        e.stopPropagation();

        $('.selected').removeClass('selected');
        $(this).toggleClass('selected');
      },
      /**
       * 각 셀들에 정렬 정보를 표시한다.
       * @memberof WidgetBox
       * */
      setOrdering: function () {
        $('.widgetarea').find('.order').each(function (i, ele) {
          $(ele).text(i);
        });
      },
      /**
       * 선택한 셀을 deselect한다.
       * @memberof WidgetBox
       * */
      deselectAll: function () {
        $('.selected').removeClass('selected');
      },
      /**
       * 설정 레이어를 오픈한다.
       * @memberof WidgetBox
       * */
      openConfig: function () {
        var $this = $(this);
        var widgetCode = $this.siblings('.widgetCode').val();
        var $widget = $this.closest('.widget');

        $('#widgetGen').widgetGenerator().reset(widgetCode, function () {

          WidgetSnb.toggleWidgetAddLayer('modify', $('.widget').index($widget));
        });
      },
      /**
       * 위젯박스에 표시된 위젯을 삭제한다.
       * @memberof WidgetBox
       * */
      delWidget: function () {
        var $column = $(this).parents('.widgetarea').closest("div[class^='xe-col-']");

        if (_this.checkReducibleBlock($column, $(this).closest('.widget'))) {
          _this.reduceBlockSize($column);
        }

        $(this).closest('.xe-row').remove();

      },
      /**
       * 삭제 될수 있는 셀인지 체크한다.
       * @memberof WidgetBox
       * @param {element} $column
       * @param {element} $widget
       * @return {boolean}
       * @description
       * [1]클릭된 widget의 widgetarea 체크
       * [2]siblings 체크
       * */
      checkReducibleBlock: function ($column, $widget) {
        var check = false;
        var widgetCnt = $column.find('.widget').length;
        var widgetareaHeight = $column.find('.widgetarea').outerHeight();
        var widgetHeight = $widget.parent().outerHeight();

        if ((widgetareaHeight - 165) >= 140 && (widgetareaHeight - ((widgetCnt - 1) * widgetHeight)) > 165) {
          check = true;
        }

        if (check) {
          $('.editor > .xe-row').has($column).find('.widgetarea-row:last-child').not($column.parents('.xe-row')).not($column.closest('.widgetarea-row').siblings()).each(function () {
            var $widgetarea = $(this).find('.widgetarea');
            var widgetsCnt = $widgetarea.find('.widget').length;

            if (widgetsCnt > 0) {
              var widgetareaHeight = $widgetarea.outerHeight();

              if ((widgetareaHeight - 165) >= 140 && (widgetareaHeight - (widgetsCnt * widgetHeight)) > 165) {
                check = true;

              } else {
                check = false;
                return false;
              }

            } else {
              if ($widgetarea.outerHeight() > 140) {
                check = true;

              } else {
                check = false;
                return false;
              }
            }
          });
        }

        return check;
      },
      /**
       * 셀의 높이값을 줄인다.
       * @param {element} $column
       * @memberof WidgetBox
       * */
      reduceBlockSize: function ($column) {
        var $widgetarea = $column.find('.widgetarea');
        var colWidgetHeight = $widgetarea.outerHeight();

        $widgetarea.setHeight(colWidgetHeight - 165);

        $('.editor > .xe-row').has($column).find('.widgetarea-row:last-child').not($column.parents('.xe-row')).not($column.closest('.widgetarea-row').siblings()).each(function () {
          var $this = $(this);
          var $widgetarea = $this.find('.widgetarea');
          var widgetareaHeight = $widgetarea.outerHeight();

          $widgetarea.setHeight(widgetareaHeight - 165);
        });
      },
      /**
       * 셀의 높이값을 늘린다.
       * @param {element} $column
       * @memberof WidgetBox
       * */
      increaseBlockSize: function ($column) {

        var $widgetarea = $column.find('.widgetarea');
        var widgetHeight = $widgetarea.find('.widget').parent().outerHeight();
        var widgetCnt = $widgetarea.find('.widget').length;

        //해당 박스에 위젯이 들어갈 공간이 없을 경우
        if ($widgetarea.outerHeight() < widgetHeight * widgetCnt) {
          var widgetareaHeight = $column.find('.widgetarea').outerHeight();
          $column.find('.widgetarea').setHeight(widgetareaHeight + 165);

          $('.editor > .xe-row:has(.selected)').find('.widgetarea-row:last-child:not(:has(.selected))').not($('.selected').closest('.widgetarea-row').siblings()).each(function () {
            var $widgetarea = $(this).find('.widgetarea');
            var widgetareaHeight = $widgetarea.outerHeight();

            $widgetarea.setHeight(widgetareaHeight + 165);
          });
        }
      },
    };
  })();
})(window);
