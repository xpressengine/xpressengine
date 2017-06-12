(function () {
  var _this;
  var _$wrap = $('#menuContainer');
  var _menus = $('#menuContainer').data('menus');
  var _menusUrl = $('#menuContainer').data('createmenu');
  var _home = $('#menuContainer').data('home');

  return {
    init: function () {
      _this = this;

      //menu 생성
      this.appendDefaultTemplate();

      //Search bar 생성
      SearchHead.init(_$wrap.find('.searchWrap'), _menus);

      this.runSortable();

      return this;
    },

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
         '<div class="menu-type">',
            Menu.render(menus[prop], _menusUrl),
            Item.render(menus[prop].items, _menusUrl, _home),
         '</div>',
        ]);
      }

      return menu.join('\n');
    },

    runSortable: function () {
      _$wrap.find('.menu-type').nestedSortable({
        forcePlaceholderSize: true,
        helper:	'clone',
        handle: '.item-content .handler',
        items: '.item',
        listType: 'div',
        opacity: .6,
        placeholder: 'item copy',
        isTree: true,
        cancel: '',
        relocate: function (e, locate) {
          console.log(e, locate);
        },

        isAllowed: function (placeholder, placeholderParent, currentItem) {
          console.log(placeholderParent);
          if (placeholderParent && placeholderParent.is('.menu-type') ||
              placeholderParent && placeholderParent.is('.item-container')) {
            return true;
          } else {
            return false;
          }
        },
      });
    },

    appendDefaultTemplate: function () {
      _$wrap.append(this.getTemplate());
    },
  }.init();
})();
