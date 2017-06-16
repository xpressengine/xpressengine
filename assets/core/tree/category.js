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
        $(this).closest('.__xe_item_wrap').toggleClass('open');
      });

      _$wrap.on('click', '.btnClose', function () {
        var $this = $(this);

        $this.parents('.__xe_item_wrap').removeClass('open');
        $this.parents('.panel').find('.lang-editor-box').each(function () {
          langEditorBoxRender($(this));
        });

      });

      _$wrap.on('click', '.btnSaveCategory', this.save);

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
              $parent: $this.parents('.item'),
              $icon: $this,
              id: item.id,
            });
        }
      });

      _$wrap.on('click', '.btnEditCategory', function () {
        var $this = $(this);
        var $content = $this.closest('.item').find('> .item-content');

        $content.find('.__xe_content_body').html(_this.getFormTemplate({ title: '편집' }));
        $content.find('.lang-editor-box').each(function () {
          langEditorBoxRender($(this));
        });

        $content.closest('.item').addClass('open');
      });

      _$wrap.on('click', '.btnNestedCategory', function () {
        var $this = $(this);
        var $content = $this.closest('.item').find('> .item-content');

        $content.find('.__xe_content_body').html(_this.getFormTemplate({ title: '하위 목록 생성' }));
        $content.find('.lang-editor-box').each(function () {
          langEditorBoxRender($(this));
        });

        $content.closest('.item').addClass('open');
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
            _this.getFormTemplate({ title: '생성' }),
            '<div class="panel-footer">',
              '<div class="pull-right">',
                '<button type="button" class="btn btn-default btnClose">닫기</button>',
                '<button type="submit" class="btn btn-primary btnSaveCategory">저장</button>',
              '</div>',
            '</div>',
          '</div>',
        '</div>',
        '<div class="panel-body __category_body">',
        '</div>',
      ].join('\n');
    },

    getFormTemplate: function (obj) {
      return [
        '<form>',
          '<div class="panel-heading">',
            '<div class="pull-left">',
              '<strong class="panel-title">' + obj.title + '</strong>',
            '</div>',
          '</div>',
          '<div class="panel-body">',
            '<div class="form-group">',
              '<label>단어</label>',
              '<div class="lang-editor-box" data-name="word" data-autocomplete="false"></div>',
            '</div>',
            '<div class="form-group">',
              '<label>설명</label>',
              '<div class="lang-editor-box" data-name="description" data-autocomplete="false" data-multiline="true"></div>',
            '</div>',
          '</div>',
        '</form>',
      ].join('\n');
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

    save: function () {

      XE.ajax({
        url: _config.add,
        type: 'post',
        dataType: 'json',
        data: data,
        success: function (node) {

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
      console.log(obj);

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

          var itemData = obj.item.find('> .item-content').data('item');

          itemData.parentId = (obj.parentId) ? obj.parentId : null;
          itemData.ordering = obj.ordering;

          obj.item.find('> .item-content').attr('data-item', JSON.stringify(itemData));
        },
      });
    },

  };
})();
