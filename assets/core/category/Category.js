/**
 * @namespace Category
 * @type {object}
 */
var Category = (function (XE, $, Tree) {
  /**
   * @private
   */
  var _this
  /**
   * @private
   */
  var _$wrap = $('#__xe_category-tree-container')
  /**
   * @private
   */
  var _config = {}

  return {
    /**
     * 카테고리 초기화
     * @memberof Category
     * @param {object} config
     * @return {object}
     */
    init: function (config) {
      _this = this

      _config = config

      this.render()
      this.bindEvents()
      this.load({
        $parent: $('.__category_body'),
        isRoot: true
      })

      _$wrap.find('.lang-editor-box').each(function () {
        window.langEditorBoxRender($(this)) // @FIXME
      })

      return this
    },

    /**
     * 카테고리 템플릿을 화면에 그린다.
     * @memberof Category
     */
    render: function () {
      _$wrap.html(this.getHeadTemplate())
    },

    /**
     * Category에서 사용되는 이벤트를 정의한다.
     * @memberof Category
     */
    bindEvents: function () {
      _$wrap.on('click', '.btnOpenForm', function () {
        $('.__xe_content_body').closest('.item, .__xe_item_wrap').removeClass('open')
        $('.btnEditCategory, .btnNestedCategory').data({ open: false })
        $(this).closest('.__xe_item_wrap').toggleClass('open')
      })

      _$wrap.on('click', '.btnClose', function () {
        var $this = $(this)

        $this.closest('.__xe_item_wrap').removeClass('open')
        $this.closest('.panel').find('.lang-editor-box').each(function () {
          window.langEditorBoxRender($(this)) // @FIXME
        })
      })

      _$wrap.on('click', '.btnSaveCategory', function () {
        var $this = $(this)
        var $form = $this.closest('.__xe_content_body').find('form')
        var data = _this.formToJson($form)

        var $body = $form.closest('.__xe_content_body')

        if ($body.find('[name=type]').length > 0) {
          data.type = $body.find('[name=type]').val()
        }

        if ($body.find('[name=id]').length > 0) {
          data.id = $body.find('[name=id]').val()
        }

        if ($body.find('[name=parent_id]').length > 0) {
          data.parent_id = $body.find('[name=parent_id]').val()
        }

        _this.save(data)
      })

      _$wrap.on('click', '.btnRemoveCategory', function () {
        _this.remove($(this).closest('.item-content').data('item'))
      })

      _$wrap.on('click', '.btnRemoveAllCategory', function () {
        _this.removeAll($(this).closest('.item-content').data('item'))
      })

      _$wrap.on('click', '.__xe_btn_toggle_children', function () {
        var $this = $(this)
        var item = $this.closest('.item').find('> .item-content').data('item')

        switch ($this.data('status')) {
          case 'loading' :
            break
          case 'open' :
            _this.setIconByStatus($this, 'close')
            _this.closeNestedItem({
              $parent: $this.closest('.item')
            })

            break
          case 'close' :
            _this.setIconByStatus($this, 'open')
            $this.closest('.item').find('> .item-container').show()

            break
          default :
            _this.setIconByStatus($this, 'loading')
            _this.load({
              $parent: $this.closest('.item'),
              $icon: $this,
              id: item.id
            })
        }
      })

      _$wrap.on('click', '.btnEditCategory', function () {
        var $this = $(this)
        var $content = $this.closest('.item').find('> .item-content')
        var $item = $content.closest('.item')
        var item = $content.data('item')

        if (!$this.data('open')) {
          var formData = {
            title: XE.Lang.trans('xe::edit'), // 편집
            wordLangKey: item.word,
            descriptionLangKey: item.description,
            removeButton: true,
            removeAllButton: true,
            saveButton: true,
            type: 'modify',
            id: $this.closest('.item-content').data('item').id
          }

          $content.find('.__xe_content_body').html(_this.getFormTemplate(formData))
          $content.find('.lang-editor-box').each(function () {
            window.langEditorBoxRender($(this)) // @FIXME
          })

          $this.data({ open: true })
          $this.siblings().data({ open: false })
          $('.__xe_content_body').closest('.item, .__xe_item_wrap').removeClass('open')
          $item.addClass('open')
        } else {
          $this.data({ open: false })
          $this.siblings().data({ open: false })
          $('.__xe_content_body').closest('.item, .__xe_item_wrap').removeClass('open')
          $item.removeClass('open')
          $('.btnEditCategory').data({ open: false })
        }
      })

      _$wrap.on('click', '.btnNestedCategory', function () {
        var $this = $(this)
        var $content = $this.closest('.item').find('> .item-content')
        var $item = $content.closest('.item')

        if (!$this.data('open')) {
          var formData = {
            title: XE.Lang.trans('xe::createChild'), // 하위 목록 생성
            saveButton: true,
            type: 'add',
            parentId: $this.closest('.item-content').data('item').id
          }

          $content.find('.__xe_content_body').html(_this.getFormTemplate(formData))
          $content.find('.lang-editor-box').each(function () {
            window.langEditorBoxRender($(this)) // @FIXME
          })

          $this.data({ open: true })
          $this.siblings().data({ open: false })
          $('.__xe_content_body').closest('.item, .__xe_item_wrap').removeClass('open')
          $item.addClass('open')
        } else {
          $this.data({ open: false })
          $this.siblings().data({ open: false })
          $('.__xe_content_body').closest('.item, .__xe_item_wrap').removeClass('open')
          $item.removeClass('open')
          $('.btnNestedCategory').data({ open: false })
        }
      })
    },

    /**
     * Category 템플릿을 리턴한다.
     * @memberof Category
     * @return {array}
     */
    getHeadTemplate: function () {
      return [
        '<div class="__xe_sortable-new panel-heading __xe_item_wrap">',
        '<div class="pull-left">',
        '<h3 class="panel-title">카테고리</h3>',
        '</div>',
        '<div class="pull-right">',
        '<button class="btn btn-primary btnOpenForm"><i class="xi-plus"></i><span>' + XE.Lang.trans('xe::addItem') + '</span></button>',
        '</div>',
        '<div class="panel panel-edit __xe_content_body">',
        _this.getFormTemplate({ title: XE.Lang.trans('xe::create'), closeButton: true, saveButton: true, type: 'add' }),
        '</div>',
        '</div>',
        '<div class="panel-body __category_body">',
        '</div>'
      ].join('\n')
    },

    /**
     * Category form 템플릿을 리턴한다
     * @memberof Category
     * @param {object} obj
     * <pre>
     *   -wordLangKey
     *   -descriptionLangKey
     *   -title
     *   -type
     *   -id
     *   -parentId
     * </pre>
     * @return {string}
     */
    getFormTemplate: function (obj) {
      var wordKeyProp = obj.hasOwnProperty('wordLangKey') ? 'data-lang-key="' + obj.wordLangKey + '"' : ''
      var descriptionKeyProp = obj.hasOwnProperty('descriptionLangKey') ? 'data-lang-key="' + obj.descriptionLangKey + '"' : ''

      var template = ''

      template += '<form>'
      template += '<div class="panel-heading">'
      template += '<div class="pull-left">'
      template += '<strong class="panel-title">' + obj.title + '</strong>'
      template += '</div>'
      template += '</div>'
      template += '<div class="panel-body">'
      template += '<div class="form-group">'
      template += '<label>' + XE.Lang.trans('xe::word') + '</label>'
      template += '<div class="lang-editor-box" data-name="word" data-autocomplete="false" ' + wordKeyProp + '></div>'
      template += '</div>'
      template += '<div class="form-group">'
      template += '<label>' + XE.Lang.trans('xe::description') + '</label>'
      template += '<div class="lang-editor-box" data-name="description" data-autocomplete="false" data-multiline="true" ' + descriptionKeyProp + '></div>'
      template += '</div>'
      template += '</div>'
      template += '</form>'

      template += '<div class="panel-footer">'
      template += '<div class="pull-right">'

      if (obj.closeButton) {
        template += '<button type="button" class="btn btn-default btnClose">' + XE.Lang.trans('xe::close') + '</button>'
      }

      if (obj.removeButton) {
        template += '<button type="button" class="btn btn-default btnRemoveCategory">' + XE.Lang.trans('xe::delete') + '</button>'
      }

      if (obj.removeAllButton) {
        template += '<button type="button" class="btn btn-default btnRemoveAllCategory">' + XE.Lang.trans('xe::subCategoryDestroy') + '</button>'
      }

      if (obj.saveButton) {
        template += '<button type="button" class="btn btn-primary btnSaveCategory">' + XE.Lang.trans('xe::save') + '</button>'
      }

      template += '</div>'
      template += '</div>'

      if (obj.hasOwnProperty('type')) {
        template += '<input type="hidden" name="type" value="' + obj.type + '">'
      }

      if (obj.hasOwnProperty('id')) {
        template += '<input type="hidden" name="id" value="' + obj.id + '">'
      }

      if (obj.hasOwnProperty('parentId') && obj.parentId) {
        template += '<input type="hidden" name="parent_id" value="' + obj.parentId + '">'
      }

      return template
    },
    /**
     * nested Item을 닫는다.
     * @memberof Category
     * @param {object} params
     */
    closeNestedItem: function (params) {
      var $parent = params.$parent

      $parent.find('> .item-container').hide()
    },

    /**
     * @memberof Category
     * @param {object} $target icon target
     * @param {string} status loading, open, close
     */
    setIconByStatus: function ($target, status) {
      $target.removeClass('xi-angle-right xi-angle-down xi-refresh xi-spin')

      switch (status) {
        case 'loading':
          $target.addClass('xi-refresh xi-spin').data('status', 'loading')
          break
        case 'open':
          $target.addClass('xi-angle-down').data('status', 'open')
          break
        case 'close':
          $target.addClass('xi-angle-right').data('status', 'close')
          break
      }
    },
    /**
     * node 템플릿을 리턴한다.
     * @memberof Category
     * @param {object} item
     * @return {string}
     */
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
        '<div class="panel panel-edit __xe_content_body"></div>'
      ].join('\n')
    },
    /**
     * sortable tree를 실행한다.
     * @memberof Category
     */
    runSortable: function () {
      Tree.run($('.__category_body'), {
        update: _this.move
      })
    },
    /**
     * item상태를 저장한다.
     * @memberof Category
     */
    save: function (item) {
      $('button').prop('disabled', true)

      XE.ajax({
        url: _config[item.type],
        type: 'post',
        dataType: 'json',
        data: item,
        success: function (data) {
          $('button').prop('disabled', false)

          switch (item.type) {
            case 'add':
              var $container = (item.hasOwnProperty('parent_id')) ? $('#item_' + item.parent_id) : $('.__category_body > .item-container')

              if ($container.hasClass('open')) {
                $container.removeClass('open')
              }

              // +아이템 추가
              if ($container.hasClass('item-container')) {
                Tree.add($container, {
                  nested: false,
                  items: [data],
                  nodeTemplate: _this.getNodeTemplate
                }, function () {
                  _$wrap.find('.btnClose').trigger('click')
                })

              // 하위 추가, 수정
              } else {
                switch ($container.find('> .item-content .__xe_btn_toggle_children').data('status')) {
                  case 'open':
                    Tree.add($container, {
                      nested: true,
                      items: [data],
                      nodeTemplate: _this.getNodeTemplate
                    })
                    break

                  case 'close':
                    Tree.add($container, {
                      nested: true,
                      items: [data],
                      nodeTemplate: _this.getNodeTemplate
                    })
                    $container.find('> .item-content .__xe_btn_toggle_children').trigger('click')
                    break

                  default:
                    $container.find('> .item-content .__xe_btn_toggle_children').trigger('click')
                }
              }

              break
            case 'modify':
              var $item = $('#item_' + item.id)

              $item.find('> .item-content').data({ item: data })
              $item.find('> .item-content .__xe_word').text(data.readableWord)
              $item.find('> .item-content .btnEditCategory').trigger('click')

              break
          }
        },

        complete: function () {
          $('button').prop('disabled', false)
        }
      })
    },
    /**
     * 아이템 정보를 로드한다.
     * @memberof Category
     * @param {object} params
     */
    load: function (params) {
      var data = {}
      var $parent = params.$parent
      var $icon = params.$icon
      var id = params.id

      if (id) {
        data.id = id
      }

      XE.ajax({
        url: _config.load,
        type: 'get',
        data: data,
        dataType: 'json',
        success: function (nodes) {
          if ($icon) {
            _this.setIconByStatus($icon, 'open')
          }

          if (nodes.length > 0) {
            var filterNodes = {}

            $parent.find('.item').remove()

            $parent.append(Tree.getItemsTemplate({
              items: nodes,
              nodeTemplate: _this.getNodeTemplate
            }))
          }

          if (params.isRoot) {
            _this.runSortable()
          }
        }
      })
    },

    /**
     * 아이템 변경 내용을 저장한다.
     * @memberof Category
     * @param {object} obj
     * <pre>
     *   item
     *   itemId
     *   parentId
     *   ordering
     * </pre>
     */
    move: function (obj) {
      var data = {
        id: obj.itemId,
        parent_id: obj.parentId ? obj.parentId : '',
        ordering: obj.ordering
      }

      Tree.setPrevent(true)

      XE.ajax({
        url: _config.move,
        type: 'post',
        data: data,
        dataType: 'html',
        success: function (response) {
          Tree.setPrevent(false)

          if ($('#item_' + data.parent_id).length > 0) {
            var $icon = $('#item_' + data.parent_id).find('> .item-content .__xe_btn_toggle_children')
            var status = $icon.data('status')

            if (status !== 'open') {
              $icon.trigger('click')
            }
          } else {
            var itemData = obj.item.find('> .item-content').data('item')

            itemData.parentId = (obj.parentId) ? obj.parentId : null
            itemData.ordering = obj.ordering

            obj.item.find('> .item-content').attr('data-item', JSON.stringify(itemData))
          }
        },

        complete: function () {
          Tree.setPrevent(false)
        }
      })
    },
    /**
     * 아이템을 삭제한다.
     * @memberof Category
     * @param {string} id
     */
    remove: function (item) {
      var that = this

      if (confirm(XE.Lang.trans('xe::confirmDelete')) == false) {
        return
      }

      XE.ajax({
        url: _config.remove,
        type: 'post',
        dataType: 'json',
        data: { id: item.id },
        success: function () {
          var $parent = $('.__category_body')
          var isRoot = true
          $('.item-container', $parent).remove()

          that.load({
            $parent: $parent,
            isRoot: isRoot
          })
        }
      })
    },
    /**
    * 아이템을 하위 카테고리까지 삭제한다.
    * @memberof Category
    * @param {string} id
    */
    removeAll: function (item) {
      var that = this

      if (confirm(XE.Lang.trans('xe::confirmDelete')) == false) {
        return
      }

      XE.ajax({
        url: _config.removeAll,
        type: 'post',
        dataType: 'json',
        data: { id: item.id },
        success: function () {
          var $parent = $('.__category_body')
          var isRoot = true
          $('.item-container', $parent).remove()

          that.load({
            $parent: $parent,
            isRoot: isRoot
          })
        }
      })
    },
    /**
     * Form요소를 JSON형태로 리턴한다.
     * @memberof Category
     * @param {element} $form
     * @return {object}
     */
    formToJson: function ($form) {
      var params = {}
      var items = $form.serializeArray()

      for (var i in items) {
        params[items[i].name] = items[i].value
      }

      return params
    }
  }
})(window.XE, window.jQuery, window.Tree)
// @FIXME window.Tree
