/**
 * @module SiteMap
 */
var SiteMap = (function (XE, $, Tree, SearchHead, Menu) {
  var _this
  var _$wrap = $('#menuContainer')
  var _menus = $('#menuContainer').data('menus')
  var _menusUrl = $('#menuContainer').data('createmenu')
  var _home = $('#menuContainer').data('home')
  var _url = $('#menuContainer').data('url')

  return {
    /**
     * SiteMap 초기설정을 한다.
     * @private
     * @memberof module:SiteMap
     * @return {object}
     * @instance
     */
    init: function () {
      _this = this

      // menu 생성
      this.appendDefaultTemplate()

      // Search bar 생성
      SearchHead.init(_$wrap.find('.searchWrap'), _menus, _menusUrl)

      this.runSortable()

      // Tree.run()

      this.bindEvents()

      return this
    },

    /**
     * sitemap페이지에서 사용되는 기본 dom 템플릿을 리턴한다.
     * @memberof module:SiteMap
     * @instance
     * @return htmlstring
     */
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
        '</div>'
      ].join('\n')
    },
    getUrl: function (item) {
      var url = item.url
      if (item.type !== 'xpressengine@directLink') {
        url = '/' + url
        url = XE.Utils.getUri(window.XE.config.getters['router/origin'] + url) // @FIXME
      }

      return url
    },
    /**
     * Node 템플릿을 리턴한다.
     * @memberof module:SiteMap
     * @param {object} item
     * @return {string}
     * @instance
     */
    getNodeTemplate: function (item) {
      var url = _this.getUrl(item)
      var homeOn = ''
      if (item.id == _home) {
        url = '/'
        homeOn = 'home-on'
      }

      var temp = ''
      temp += "<div class='item-info'>"
      temp += "<i class='xi-paper'></i>"
      temp += '<dl>'
      temp += "<dt class='sr-only'>" + XE.Lang.trans(item.title) + '</dt>'
      temp += "<dd class='ellipsis'><a href='" + _menusUrl + '/' + item.menu_id + '/items/' + item.id + "'>" + XE.Lang.trans(item.title) + '</a></dd>'
      temp += "<dt class='sr-only'>" + url + '</dt>'
      temp += "<dd class='text-blue ellipsis'><a href='" + url + "' class='item-url'>" + url + '</a><em>[' + item.type + ']</em></dd>'
      temp += '</dl>'
      temp += '</div>'
      temp += '<div class="btn-group pull-right">'
      temp += '<button type="button" class="btn-more visible-xs"><i class="xi-ellipsis-v"></i></button>'
      temp += '<button type="button" class="btn btn-link btn-sethome hidden-xs ' + homeOn + '"><i class="xi-home"></i></button>'
      temp += '</div>'
      temp += '<div class="visible-xs more-area" style="display: none !important;">'
      temp += '<button class="btn btn-sethome" type="button">' + XE.Lang.trans('xe::setHome') + '</button><a href="' + url + '" class="btn">' + XE.Lang.trans('xe::goLink') + '</a>'
      temp += '</div>'

      return temp
    },
    /**
     * Menu에 사용되는 HTML을 만든다.
     * @memberof module:SiteMap
     * @param {object} menus
     * @return {string}
     * @instance
     */
    generateDom: function (menus) {
      var menu = []

      for (var prop in menus) {
        menu = menu.concat([
          '<div class="menu-type">',
          Menu.render(menus[prop], _menusUrl),
          Tree.getItemsTemplate({
            rootId: prop,
            items: menus[prop].items,
            nodeTemplate: _this.getNodeTemplate
          }),
          '</div>'
        ])
      }

      return menu.join('\n')
    },
    /**
     * 사이트맵에서 사용되는 이벤트 핸들러를 등록한다.
     * @memberof module:SiteMap
     * @instance
     */
    bindEvents: function () {
      $('.btn-more').on('click', function () {
        var $moreArea = $(this).parents('.item-content').find('.more-area')

        if ($moreArea.hasClass('on')) {
          $moreArea.removeClass('on').css('cssText', 'display: none !important')
        } else {
          $('.more-area').removeClass('on').css('cssText', 'display: none !important')
          $moreArea.addClass('on').css('cssText', 'display: block !important')
        }
      })

      $('.btn-sethome').on('click', function () {
        var $this = $(this)

        if (!$this.hasClass('home-on')) {
          var $currentHome = $('.home-on')
          var $currentItem = $currentHome.closest('.item-content')
          var $thisItem = $this.closest('.item-content')
          var selectedItemData = $thisItem.data('item')

          _this.changeHome($currentItem, $thisItem)

          Tree.setPrevent(true)

          XE.ajax({
            url: _url + '/setHome',
            context: $('.menu-content'),
            type: 'put',
            dataType: 'json',
            data: {
              itemId: selectedItemData.id
            },
            success: function (data) {
              XE.toast('success', XE.Lang.trans(selectedItemData.title) + ' is home!')

              Tree.setPrevent(false)
            },

            error: function (data) {
              XE.toast('error', 'home setting was failed!')
              _this.changeHome($thisItem, $currentItem)
            }
          })
        }
      })
    },
    /**
     * @memberof module:SiteMap
     * @instance
     */
    changeHome: function ($current, $selected) {
      $current.find('.btn-sethome').removeClass('home-on')
      var currentOriginUrl = _this.getUrl($current.data('item'))
      $current.find('.item-url').attr('href', currentOriginUrl).text(currentOriginUrl)
      $selected.find('.btn-sethome').addClass('home-on')
      $selected.find('.item-url').attr('href', '/').text('/')

      _home = $selected.data('item').id
    },
    /**
     * Tree를 구성한다.
     * @memberof module:SiteMap
     * @instance
     */
    runSortable: function () {
      var config = {
        update: _this.updateNode
      }

      Tree.run(_$wrap, config)
    },
    /**
     * 기본템플릿을 구성한다.
     * @memberof module:SiteMap
     * @instance
     */
    appendDefaultTemplate: function () {
      _$wrap.append(this.getTemplate())
    },
    /**
     * Node정보를 저장한다.
     * @memberof module:SiteMap
     * @param {object} obj
     * <pre>
     *   item: jquery object. move된 NODE
     *   itemId: node id
     *   parentId: parent node id
     *   ordering: node ordering
     * </pre>
     * @description 변경된 Node를 업데이트 한다
     * @instance
     */
    updateNode: function (obj) {
      Tree.setPrevent(true)

      XE.ajax({
        url: _url + '/moveItem',
        context: $('.menu-content'),
        type: 'put',
        dataType: 'json',
        data: {
          itemId: obj.itemId,
          parent: obj.parentId,
          ordering: obj.ordering
        },
        success: function (data) {
          var itemData = obj.item.find('> .item-content').data('item')
          var currentMenuId = (obj.item.parents('.item').length > 0) ? obj.item.parents('.item').parents('.item-container:last()').data('parent') : obj.item.parent().data('parent')

          itemData.parentId = (obj.parentId) ? obj.parentId : null
          itemData.ordering = obj.ordering

          obj.item.find('> .item-content').attr('data-item', JSON.stringify(itemData))

          if (itemData.menu_id != currentMenuId) {
            _this.updateMenuId(obj.item, currentMenuId)
          }

          XE.toast('success', 'Item moved')

          Tree.setPrevent(false)
        }
      })
    },
    /**
     * UI상의 MenuId를 업데이트한다.
     * @memberof module:SiteMap
     * @param {element} $item
     * @param {string} menuId
     * @description
     * <pre>
     *   - 하위 노드를 찾아가며 menuId를 변경한다
     *   - 재귀
     * </pre>
     * @instance
     */
    updateMenuId: function ($item, menuId) {
      var itemData = $item.find('> .item-content').data('item')
      var $link = $item.find('> .item-content .item-info .ellipsis:eq(0) a')
      var href = $link.attr('href')
      var stdParsing = '/menu/menus/'

      var arrLinks = href.split(stdParsing)
      var secLinks = arrLinks[1].split('/')
      secLinks[0] = menuId

      var link = arrLinks[0] + stdParsing + secLinks.join('/')

      itemData.menu_id = menuId
      $item.find('> .item-content').attr('data-item', JSON.stringify(itemData))
      $link.attr('href', link)

      if ($item.find('> .item-container > .item').length > 0) {
        _this.updateMenuId($item.find('> .item-container > .item'), menuId)
      }
    }
  }.init()
})(window.XE, window.jQuery, window.Tree, window.SearchHead, window.Menu)
