var SearchHead = (function () {
  var _this;
  var _data = {};
  var _createMenuUrl;
  var _$parent = $();
  var _searchData = [];

  return {
    init: function ($parent, data, createMenuUrl) {
      _this = this;
      _data = data;
      _createMenuUrl = createMenuUrl;
      _$parent = $parent;

      for (var prop in data) {
        var items = data[prop].items;

        this.makeSearchData(items);
      }

      this.render();
      this.cache();
      this.bindEvents();

      return this;
    },

    getTemplate: function () {
      return [
        '<div class="pull-left">',
          '<div class="input-group search-group">',
            '<input type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Search...">',
            '<button class="btn-link"><i class="xi-search"></i><span class="sr-only">검색</span></button>',
            '<div class="search-list"></div>',
          '</div>',
        '</div>',
        '<div class="pull-right">',
          '<a href="' + _createMenuUrl + '" class="btn btn-primary pull-right">',
            '<i class="xi-plus"></i>',
            '메뉴 추가',
          '</a>',
        '</div>',
      ].join('\n');
    },

    render: function ($parent) {
      _$parent.append(_this.getTemplate());
    },

    cache: function (data) {
      this.$searchInput = $('.search-group > input');
      this.$btnLink = $('.btn-link');
      this.$searchList = $('.search-list');
    },

    bindEvents: function () {
      this.$searchInput.on('keyup', this.search);
    },

    makeSearchData: function (items) {
      if (items && items instanceof Object) {
        for (var prop in items) {
          var item = items[prop];

          _searchData.push({
            id: item.id,
            title: XE.Lang.trans(item.title),
          });

          _this.makeSearchData(item.items);
        }
      }
    },

    search: function (e) {
      var value = e.target.value;
      var list = '';

      if (value.length > 1) {
        var suggestion = [];

        $.each(_searchData, function (idx, obj) {
          if (obj.title.indexOf(value) != -1) {
            suggestion.push(obj);
          }
        });

        if (suggestion.length > 0) {
          list += '<ul>';

          $.each(suggestion, function (idx, obj) {
            var title = obj.title.split(value).join('<em>' + value + '</em>');

            list +=   '<li>' + title + '</li>';
          });

          list += '</ul>';

          _this.$searchList.html(list);
        }

      } else {
        _this.$searchList.empty();
      }
    },
  };
})();
