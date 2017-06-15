var Category = (function () {
  var _this;
  var _$wrap = $('#__xe_category-tree-container');

  return {
    init: function () {
      _this = this;

      this.render();
      
      return this;
    },
    render: function () {
      _$wrap.html(this.getHeadTemplate());
    },
    getHeadTemplate: function () {
      return [
        '<div class="__xe_sortable-new panel-heading">',
          '<div class="pull-left">',
            '<h3 class="panel-title">카테고리</h3>',
          '</div>',
          '<div class="pull-right">',
            '<button class="btn btn-primary __xe_btn_new"><i class="xi-plus"></i><span>아이템 추가</span></button>',
          '</div>',
          '<div class="panel panel-edit __xe_content_body">' + _this.getFormTemplate({ title: '생성' }) + '</div>',
        '</div>',
      ].join('\n');
    },

    getFormTemplate: function (obj) {
      return [
        '<div class="panel panel-edit">',
          '<form>',
            '<div class="panel-heading">',
              '<div class="panel-left">',
                '<strong>' + obj.title + '</strong>',
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
        '</div>',
      ];
    },
  }.init();
})();
