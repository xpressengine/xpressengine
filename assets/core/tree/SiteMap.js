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

    appendDefaultTemplate: function () {
      _$wrap.append(this.getTemplate());
    },
  }.init();
})();
