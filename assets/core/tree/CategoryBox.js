var CategoryBox = (function () {
  var _this;

  return {
    /**
     * @param obj
     * <pre>
     *   - title
     * </pre>
     * */
    getTemplate: function (obj) {
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
  };
})();
