var TitleHead = (function () {
  return {
    getTemplate: function () {
      return [
        '<div class="__xe_sortable-new panel-heading">',
          '<div class="pull-left">',
            '<h3 class="panel-title">카테고리</h3>',
          '</div>',
          '<div class="pull-right">',
            '<button class="btn btn-primary __xe_btn_new"><i class="xi-plus"></i><span>아이템 추가</span></button>',
          '</div>',
          '<div class="panel panel-edit __xe_content_body"></div>',
        '</div>',
      ].join('\n');
    },
  };
})();
