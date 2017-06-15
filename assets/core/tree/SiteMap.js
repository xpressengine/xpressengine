(function () {
  var _this;
  var _$wrap = $('#menuContainer');
  var _menus = $('#menuContainer').data('menus');
  var _menusUrl = $('#menuContainer').data('createmenu');
  var _home = $('#menuContainer').data('home');
  var _url = $('#menuContainer').data('url');
  var _loading = false;

  return {
    init: function () {
      _this = this;

      //menu 생성
      this.appendDefaultTemplate();

      //Search bar 생성
      SearchHead.init(_$wrap.find('.searchWrap'), _menus, _menusUrl);

      this.runSortable();
      this.bindEvents();

      return this;
    },

    /**
     * @description sitemap페이지에서 사용되는 기본 dom 템플릿
     * @return htmlstring
     * */
    getTemplate: function () {
      return [
       '<div class="col-sm-12">',
        '<div class="panel">',
          '<div class="panel-heading searchWrap"></div>',
          '<div class="panel-body">',
           '<div class="menu-content">',
              _this.generateDom(_menus),
           '</div>',
          '</div>',
        '</div>',
       '</div>',
      ].join('\n');
    },

    generateDom: function (menus) {
      var menu = [];

      for (var prop in menus) {
        menu = menu.concat([
         '<div class="menu-type" data-parent="' + prop + '">',
            Menu.render(menus[prop], _menusUrl),
            Item.render({
              items: menus[prop].items,
              url: _menusUrl,
              home: _home,
              type: 'sitemap',
            }),
         '</div>',
        ]);
      }

      return menu.join('\n');
    },

    bindEvents: function () {
      $('.btn-more').on('click', function () {
        var $moreArea = $(this).parents('.item-content').find('.more-area');

        if ($moreArea.hasClass('on')) {
          $moreArea.removeClass('on').css('cssText', 'display: none !important');
        } else {
          $('.more-area').removeClass('on').css('cssText', 'display: none !important');
          $moreArea.addClass('on').css('cssText', 'display: block !important');
        }
      });

      $('.btn-sethome').on('click', function () {
        var $this = $(this);

        if (!$this.hasClass('home-on')) {

          var $currentHome = $('.home-on');
          var selectedItemData = $this.closest('.item-content').data('item');

          $currentHome.removeClass('home-on');
          $this.addClass('home-on');

          _loading = true;

          XE.ajax({
            url: _url + '/setHome',
            context: $('.menu-content'),
            type: 'put',
            dataType: 'json',
            data: {
              itemId: selectedItemData.id,
            },
            success: function (data) {
              XE.toast('success', XE.Lang.trans(selectedItemData.title) + ' is home!');

              _loading = false;
            },

            error: function (data) {
              XE.toast('error', 'home setting was failed!');
              $currentHome.addClass('home-on');
              $this.removeClass('home-on');
            },
          });
        }

      });

    },

    runSortable: function () {
      var parentId;
      var ordering;
      var itemId;

      _$wrap.find('.item-container').nestedSortable({
        connectWith: '.item-container',
        forcePlaceholderSize: true,
        helper:	'clone',
        handle: '.item-content .handler',
        listType: 'ul',
        items: 'li',
        opacity: 0.6,
        placeholder: {
          element: function ($target) {
            return $target.clone().addClass('copy').show().wrapAll('<div />').parent().html();
          },

          update: function () {
            return;
          },
        },
        isTree: true,
        cancel: '',
        tolerance: 'pointer',
        toleranceElement: '> div',
        relocate: function (e, locate) {
          console.log('relocate');
        },

        receive: function (e, ui) {
          console.log('receive');
        },

        start: function (e, ui) {
          var $item = $(ui.item);
          var itemData = $item.find('> .item-content').data('item');

          parentId = itemData.parentId;
          ordering = itemData.ordering;
          itemId = itemData.id;
        },

        stop: function (e, ui) {
          var $item = $(ui.item);
          var $parentItem = $item.parents('li.item').eq(0);
          var moveParentId = ($parentItem.length > 0) ? $parentItem.find('> .item-content').data('item').id : $item.parents('.menu-type').data('parent');
          var moveOrdering = $item.closest('ul').addClass('item-container').find('> li.item').index($item);

          if (parentId !== moveParentId && !_loading || ordering !== moveOrdering && !_loading) {
            _this.updateNode({
              item: $item,
              itemId: itemId,
              parentId: moveParentId,
              ordering: moveOrdering,
            });
          }
        },

        isAllowed: function (placeholder, placeholderParent, currentItem) {
          if (_loading) {
            return false;
          } else {
            return true;
          }
        },
      });
    },

    appendDefaultTemplate: function () {
      _$wrap.append(this.getTemplate());
    },
    /**
     * @param {object} obj
     * <pre>
     *   item: jquery object. move된 NODE
     *   itemId: node id
     *   parentId: parent node id
     *   ordering: node ordering
     * </pre>
     * @description 변경된 Node를 업데이트 한다
     * */
    updateNode: function (obj) {
      _loading = true;

      XE.ajax({
        url: _url + '/moveItem',
        context: $('.menu-content'),
        type: 'put',
        dataType: 'json',
        data: {
          itemId: obj.itemId,
          parent: obj.parentId,
          ordering: obj.ordering,
        },
        success: function (data) {
          var itemData = obj.item.find('> .item-content').data('item');
          var currentMenuId = obj.item.parents('.menu-type').data('parent');

          itemData.parentId = (obj.parentId) ? obj.parentId : null;
          itemData.ordering = obj.ordering;

          obj.item.find('> .item-content').attr('data-item', JSON.stringify(itemData));

          if (itemData.menuId != currentMenuId) {
            _this.updateMenuId(obj.item, currentMenuId);
          }

          XE.toast('success', 'Item moved');

          _loading = false;
        },
      });
    },
    /**
     * @description
     * <pre>
     *   - 하위 노드를 찾아가며 menuId를 변경한다
     *   - 재귀
     * </pre>
     * */
    updateMenuId: function ($item, menuId) {
      var itemData = $item.find('> .item-content').data('item');
      var $link = $item.find('> .item-content .item-info .ellipsis:eq(0) a');
      var href = $link.attr('href');
      var stdParsing = '/menu/menus/';

      var arrLinks = href.split(stdParsing);
      var secLinks = arrLinks[1].split('/');
      secLinks[0] = menuId;

      var link = arrLinks[0] + stdParsing + secLinks.join('/');

      itemData.menuId = menuId;
      $item.find('> .item-content').attr('data-item', JSON.stringify(itemData));
      $link.attr('href', link);

      if ($item.find('> .item-container > .item').length > 0) {
        _this.updateMenuId($item.find('> .item-container > .item'), menuId);
      }
    },
  }.init();
})();
