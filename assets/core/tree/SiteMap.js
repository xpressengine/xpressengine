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

      //Tree.run()

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

    getNodeTemplate: function (item) {
      // var move = (item.items && item.items.length > 0) ? 'move' : '';
      var url = item.url;
      var homeOn = '';

      if (item.type !== 'xpressengine@directLink') {
        if (item.id == _home) {
          url = '/';
          homeOn = 'home-on';

        } else {
          url = '/' + url;
        }

        url = Utils.getUri(xeBaseURL + url);

      } else {
        url = url;
      }

      var temp = '';
      temp +=     "<div class='item-info'>";
      temp +=       "<i class='xi-paper'></i>";
      temp +=       '<dl>';
      temp +=         "<dt class='sr-only'>" + XE.Lang.trans(item.title) + '</dt>';
      temp +=         "<dd class='ellipsis'><a href='" + _menusUrl + '/' + item.menuId + '/items/' + item.id + "'>" + XE.Lang.trans(item.title) + '</a></dd>';
      temp +=         "<dt class='sr-only'>" + url + '</dt>';
      temp +=         "<dd class='text-blue ellipsis'><a href='" + url + "'>" + url + '</a><em>[' + item.type + ']</em></dd>';
      temp +=       '</dl>';
      temp +=     '</div>';
      temp +=     '<div class="btn-group pull-right">';
      temp +=       '<button type="button" class="btn-more visible-xs"><i class="xi-ellipsis-v"></i></button>';
      temp +=       '<button type="button" class="btn btn-link btn-sethome hidden-xs ' + homeOn + '"><i class="xi-home"></i></button>';
      temp +=     '</div>';
      temp +=     '<div class="visible-xs more-area" style="display: none !important;">';
      temp +=       '<button class="btn btn-sethome" type="button">' + XE.Lang.trans('xe::setHome') + '</button><a href="' + url + '" class="btn">' + XE.Lang.trans('xe::goLink') + '</a>';
      temp +=     '</div>';

      return temp;
    },

    generateDom: function (menus) {
      var menu = [];

      for (var prop in menus) {
        menu = menu.concat([
         '<div class="menu-type">',
            Menu.render(menus[prop], _menusUrl),
            Tree.getItemsTemplate({
              rootId: prop,
              items: menus[prop].items,
              nodeTemplate: _this.getNodeTemplate,
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
      var config = {
        update: _this.updateNode,
      };

      Tree.run(_$wrap, config);

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
          var currentMenuId = (obj.item.parents('.item').length > 0)? obj.item.parents('.item').parents('.item-container:last()').data('parent') : obj.item.parent().data('parent');

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
