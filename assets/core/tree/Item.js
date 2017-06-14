var Item = (function () {
  var _this = this;
  var _home;
  var _url;

  return {
    init: function () {
      _this = this;

      return this;
    },

    render: function (obj) {
      _home = obj.home;
      _url = obj.url;

      switch (obj.type) {
        case 'sitemap' :
          return _this.getSiteMapItems(obj.items, true);
          break;
        case 'category' :
          break;
      }
    },

    getSiteMapItems: function (items, isRoot) {
      var temp = '';

      if (items && items.length != 0 || isRoot) {
        temp += '<ul class="item-container">';
      }

      for (var prop in items) {
        var item = items[prop];
        var move = (item.items && item.items.length > 0) ? 'move' : '';
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

        temp += "<li class='item " + move + "' id='item_" + item.id + "'>";
        temp +=   "<div class='item-content' data-item='" + JSON.stringify(item) + "'>";
        temp +=     "<button class='btn handler'><i class='xi-drag-vertical'></i></button>";
        temp +=     "<div class='item-info'>";
        temp +=       "<i class='xi-paper'></i>";
        temp +=       '<dl>';
        temp +=         "<dt class='sr-only'>" + XE.Lang.trans(item.title) + '</dt>';
        temp +=         "<dd class='ellipsis'><a href='" + _url + '/' + item.menuId + '/items/' + item.id + "'>" + XE.Lang.trans(item.title) + '</a></dd>';
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
        temp +=   '</div>';

        if (item.items && item.items instanceof Object) {
          temp += _this.getSiteMapItems(item.items);
        }

        temp += '</liv>';

      }

      if (items && items.length != 0 || isRoot) {
        temp += '</ul>';
      }

      return temp;
      //}
    },
  }.init();
})();
