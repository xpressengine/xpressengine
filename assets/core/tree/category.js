var Category = (function () {
  var _this;
  var _$wrap = $('#__xe_category-tree-container');
  var _config = {};

  /***
    load: '{{ route('manage.category.edit.item.children', ['id' => $category->id]) }}',
    add: '{{ route('manage.category.edit.item.store', ['id' => $category->id]) }}',
    modify: '{{ route('manage.category.edit.item.update', ['id' => $category->id]) }}',
    remove: '{{ route('manage.category.edit.item.destroy', ['id' => $category->id]) }}',
    move: '{{ route('manage.category.edit.item.move', ['id' => $category->id]) }}'
    */

  return {
    init: function (config) {
      _this = this;

      _config = config;

      this.render();
      this.bindEvents();
      this.load({
        $parent: $('.__category_body'),
      });

      _$wrap.find('.lang-editor-box').each(function () {
        langEditorBoxRender($(this));
      });

      return this;
    },

    render: function () {
      _$wrap.html(this.getHeadTemplate());
    },

    bindEvents: function () {
      _$wrap.on('click', '.btnOpenForm', function () {
        $('.__xe_content_body').closest('.item, .__xe_item_wrap').removeClass('open');
        $('.btnEditCategory, .btnNestedCategory').data({ open: false });
        $(this).closest('.__xe_item_wrap').toggleClass('open');
      });

      _$wrap.on('click', '.btnClose', function () {
        var $this = $(this);

        $this.closest('.__xe_item_wrap').removeClass('open');
        $this.closest('.panel').find('.lang-editor-box').each(function () {
          langEditorBoxRender($(this));
        });

      });

      _$wrap.on('click', '.btnSaveCategory', function () {
        var $this = $(this);
        var $form = $this.closest('.__xe_content_body').find('form');
        var data = _this.formToJson($form);

        var $body = $form.closest('.__xe_content_body');

        if ($body.find('[name=type]').length > 0) {
          data.type = $body.find('[name=type]').val();
        }

        if ($body.find('[name=id]').length > 0) {
          data.id = $body.find('[name=id]').val();
        }

        if ($body.find('[name=parentId]').length > 0) {
          data.parentId = $body.find('[name=parentId]').val();
        }

        _this.save(data);
      });

      _$wrap.on('click', '.btnRemoveCategory', function () {
        var id = $(this).closest('.item-content').data('item').id;

        _this.remove(id);
      });

      _$wrap.on('click', '.__xe_btn_toggle_children', function () {
        var $this = $(this);
        var item = $this.closest('.item').find('> .item-content').data('item');

        switch ($this.data('status')) {
          case 'loading' :
            break;
          case 'open' :
            _this.setIconByStatus($this, 'close');
            _this.closeNestedItem({
              $parent: $this.closest('.item'),
            });

            break;
          case 'close' :
            _this.setIconByStatus($this, 'open');
            $this.closest('.item').find('> .item-container').show();

            break;
          default :
            _this.setIconByStatus($this, 'loading');
            _this.load({
              $parent: $this.closest('.item'),
              $icon: $this,
              id: item.id,
            });
        }
      });

      _$wrap.on('click', '.btnEditCategory', function () {
        var $this = $(this);
        var $content = $this.closest('.item').find('> .item-content');
        var $item = $content.closest('.item');
        var item = $content.data('item');

        if (!$this.data('open')) {
          var formData = {
            title: '편집',
            wordLangKey: item.word,
            descriptionLangKey: item.description,
            removeButton: true,
            saveButton: true,
            type: 'modify',
            id: $this.closest('.item-content').data('item').id,
          };

          $content.find('.__xe_content_body').html(_this.getFormTemplate(formData));
          $content.find('.lang-editor-box').each(function () {
            langEditorBoxRender($(this));
          });

          $this.data({ open: true });
          $this.siblings().data({ open: false });
          $('.__xe_content_body').closest('.item, .__xe_item_wrap').removeClass('open');
          $item.addClass('open');

        } else {
          $this.data({ open: false });
          $this.siblings().data({ open: false });
          $('.__xe_content_body').closest('.item, .__xe_item_wrap').removeClass('open');
          $item.removeClass('open');
          $('.btnEditCategory').data({ open: false });

        }
      });

      _$wrap.on('click', '.btnNestedCategory', function () {
        var $this = $(this);
        var $content = $this.closest('.item').find('> .item-content');
        var $item = $content.closest('.item');

        if (!$this.data('open')) {
          var formData = {
            title: '하위 목록 생성',
            saveButton: true,
            type: 'add',
            parentId: $this.closest('.item-content').data('item').id,
          };

          $content.find('.__xe_content_body').html(_this.getFormTemplate(formData));
          $content.find('.lang-editor-box').each(function () {
            langEditorBoxRender($(this));
          });

          $this.data({ open: true });
          $this.siblings().data({ open: false });
          $('.__xe_content_body').closest('.item, .__xe_item_wrap').removeClass('open');
          $item.addClass('open');

        } else {
          $this.data({ open: false });
          $this.siblings().data({ open: false });
          $('.__xe_content_body').closest('.item, .__xe_item_wrap').removeClass('open');
          $item.removeClass('open');
          $('.btnNestedCategory').data({ open: false });

        }

      });

    },

    getHeadTemplate: function () {
      return [
        '<div class="__xe_sortable-new panel-heading __xe_item_wrap">',
          '<div class="pull-left">',
            '<h3 class="panel-title">카테고리</h3>',
          '</div>',
          '<div class="pull-right">',
            '<button class="btn btn-primary btnOpenForm"><i class="xi-plus"></i><span>아이템 추가</span></button>',
          '</div>',
          '<div class="panel panel-edit __xe_content_body">',
            _this.getFormTemplate({ title: '생성', closeButton: true, saveButton: true, type: 'add' }),
          '</div>',
        '</div>',
        '<div class="panel-body __category_body">',
        '</div>',
      ].join('\n');
    },

    getFormTemplate: function (obj) {
      var wordKeyProp = obj.hasOwnProperty('wordLangKey') ? 'data-lang-key="' + obj.wordLangKey + '"' : '';
      var descriptionKeyProp = obj.hasOwnProperty('descriptionLangKey') ? 'data-lang-key="' + obj.descriptionLangKey + '"' : '';

      var template = '';

      template += '<form>';
      template +=   '<div class="panel-heading">';
      template +=     '<div class="pull-left">';
      template +=       '<strong class="panel-title">' + obj.title + '</strong>';
      template +=     '</div>';
      template +=   '</div>';
      template +=   '<div class="panel-body">';
      template +=     '<div class="form-group">';
      template +=       '<label>단어</label>';
      template +=       '<div class="lang-editor-box" data-name="word" data-autocomplete="false" ' + wordKeyProp + '></div>';
      template +=     '</div>';
      template +=     '<div class="form-group">';
      template +=       '<label>설명</label>';
      template +=       '<div class="lang-editor-box" data-name="description" data-autocomplete="false" data-multiline="true" ' + descriptionKeyProp + '></div>';
      template +=     '</div>';
      template +=   '</div>';
      template += '</form>';

      template += '<div class="panel-footer">';
      template +=   '<div class="pull-right">';

      if (obj.closeButton) {
        template +=   '<button type="button" class="btn btn-default btnClose">닫기</button>';
      }

      if (obj.removeButton) {
        template +=   '<button type="button" class="btn btn-default btnRemoveCategory">삭제</button>';
      }

      if (obj.saveButton) {
        template +=   '<button type="button" class="btn btn-primary btnSaveCategory">저장</button>';
      }

      template +=   '</div>';
      template += '</div>';

      if (obj.hasOwnProperty('type')) {
        template += '<input type="hidden" name="type" value="' + obj.type + '">';
      }

      if (obj.hasOwnProperty('id')) {
        template += '<input type="hidden" name="id" value="' + obj.id + '">';
      }

      if (obj.hasOwnProperty('parentId') && obj.parentId) {
        template += '<input type="hidden" name="parentId" value="' + obj.parentId + '">';
      }

      return template;
    },

    closeNestedItem: function (params) {
      var $parent = params.$parent;

      $parent.find('> .item-container').hide();
    },

    /**
     * @param {jquery object} $target icon target
     * @param {string} status loading, open, close
     * */
    setIconByStatus: function ($target, status) {
      $target.removeClass('xi-angle-right xi-angle-down xi-refresh xi-spin');

      switch (status) {
        case 'loading':
          $target.addClass('xi-refresh xi-spin').data('status', 'loading');
          break;
        case 'open':
          $target.addClass('xi-angle-down').data('status', 'open');
          break;
        case 'close':
          $target.addClass('xi-angle-right').data('status', 'close');
          break;
      }
    },

    getNodeTemplate: function (item) {
      return [
        '<div class="item-info">',
          '<i class="xi-angle-right __xe_btn_toggle_children" style="cursor: pointer;"></i>',
          '<strong class="__xe_word">' + item.readableWord + '</strong>',
        '</div>',
        '<div class="edit-btn-area __xe_toggle-btns">',
          '<button class="btn btnEditCategory"><i class="xi-pen"></i></button>',
          '<button class="btn btnNestedCategory"><i class="xi-plus"></i></button>',
        '</div>',
        '<div class="panel panel-edit __xe_content_body"></div>',
      ].join('\n');
    },

    runSortable: function () {
      Tree.run($('.__category_body'), {
        update: _this.move,
      });
    },

    save: function (item) {
      $('button').prop('disabled', true);

      XE.ajax({
        url: _config[item.type],
        type: 'post',
        dataType: 'json',
        data: item,
        success: function (data) {
          switch (item.type) {
            case 'add':

              var $container = (item.hasOwnProperty('parentId')) ? $('#item_' + item.parentId) : $('.__category_body > .item-container');

              if ($container.hasClass('open')) {
                $container.removeClass('open');
              }

              //+아이테 추가
              if ($container.hasClass('.item-container')) {
                Tree.add($container, {
                  items: data,
                  nodeTemplate: _this.getNodeTemplate,
                });

              //하위 추가, 수정
              } else {
                switch ($container.find('> .item-content .__xe_btn_toggle_children').data('status')) {
                  case 'open':
                    Tree.add($container, {
                      items: data,
                      nodeTemplate: _this.getNodeTemplate,
                    });
                    break;

                  case 'close':
                    Tree.add($container, {
                      items: data,
                      nodeTemplate: _this.getNodeTemplate,
                    });
                    $container.find('> .item-content .__xe_btn_toggle_children').trigger('click');
                    break;

                  default:
                    $container.find('> .item-content .__xe_btn_toggle_children').trigger('click');
                }
              }

              break;
            case 'modify':

              break;
          }
        },

        complete: function () {
          $('button').prop('disabled', false);
        },
      });

    },

    load: function (params) {
      var data = {};
      var $parent = params.$parent;
      var $icon = params.$icon;
      var id = params.id;

      if (id) {
        data.id = id;
      }

      XE.ajax({
        url: _config.load,
        type: 'get',
        data: data,
        dataType: 'json',
        success: function (nodes) {
          if ($icon) {
            _this.setIconByStatus($icon, 'open');
          }

          if (nodes.length > 0) {
            $parent.find('> .item-container').remove();
            $parent.append(Tree.getItemsTemplate({
              items: nodes,
              nodeTemplate: _this.getNodeTemplate,
            }));

            if (!id) {
              _this.runSortable();
            }
          }
        },
      });
    },

    /**
     * @param {object} obj
     * <pre>
     *   item
     *   itemId
     *   parentId
     *   ordering
     * </pre>
     * */
    move: function (obj) {
      var data = {
        id: obj.itemId,
        parentId: obj.parentId ? obj.parentId : '',
        ordering: obj.ordering,
      };

      Tree.setPrevent(true);

      XE.ajax({
        url: _config.move,
        type: 'post',
        data: data,
        dataType: 'html',
        success: function (response) {

          Tree.setPrevent(false);

          if ($('#item_' + data.parentId).length > 0) {
            var $icon = $('#item_' + data.parentId).find('> .item-content .__xe_btn_toggle_children');
            var status = $icon.data('status');

            if (status !== 'open') {
              $icon.trigger('click');
              return;
            }
          } else {
            var itemData = obj.item.find('> .item-content').data('item');

            itemData.parentId = (obj.parentId) ? obj.parentId : null;
            itemData.ordering = obj.ordering;

            obj.item.find('> .item-content').attr('data-item', JSON.stringify(itemData));
          }

        },
      });
    },

    remove: function (id) {
      XE.ajax({
        url: _config.remove,
        type: 'post',
        dataType: 'html',
        data: { id: id },
        success: function () {
          $('#item_' + id).remove();
        },
      });
    },

    formToJson: function ($form) {
      var formArrayData = $form.serializeArray();
      var obj = {};

      $.each(formArrayData, function (i, v) {
        obj[v.name] = v.value;
      });

      return obj;
    },
  };
})();
