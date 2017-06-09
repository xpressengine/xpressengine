var SearchHead = (function () {
  var _this;
	var _data = {};
	var _$parent = $();

  return {
    init: function ($parent, data) {
			_this = this;
			_data = data;
			_$parent = $parent;

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
					'<a href="' + _data.menus + '" class="btn btn-primary pull-right">',
						'<i class="xi-plus"></i>',
					'</a>',
				'</div>'
      ].join('\n');
    },

    render: function ($parent) {
			_$parent.append(_this.getTemplate());
    },

    cache: function (data) {
			this.$searchInput = $('.search-group > input');
			this.$btnLink = $('.btn-link');
    },

    bindEvents: function () {
			this.$searchInput.on('keyup', this.search);
    },
  };
})();
