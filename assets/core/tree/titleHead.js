var TitleHead = (function () {
  return {
    render: function (data, url) {
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

    getCreateCategoryTemplate: function () {
      return [
        '<form>',
          '<div class="panel-heading">',
            '<div class="pull-left">',
              '<strong class="panel-title">생성</strong>',
            '</div>',
          '</div>',
          '<div class="panel-body">',
            '<div class="form-group">',
              '<label>단어</label>',

        '</form>',
      ].join('\n');
      //<div class="lang-editor-box"><div data-reactroot="" class="text"><input type="hidden" name="xe_use_request_preprocessor" value="Y"><input type="hidden" name="xe_lang_preprocessor://lang/seq/3/name" value="word"><input type="hidden" name="xe_lang_preprocessor://lang/seq/3/key" value=""><input type="hidden" name="word" value=""><div class="input-group"><input type="text" class="form-control" id="input-3-ko" name="xe_lang_preprocessor://lang/seq/3/locale/ko" value=""><span class="input-group-addon"><span class="flag-code"><i class="ko xe-flag"></i><!-- react-text: 11 -->ko<!-- /react-text --></span></span></div><div class="sub"><div class="input-group"><input type="text" class="form-control" id="input-3-en" name="xe_lang_preprocessor://lang/seq/3/locale/en" value=""><span class="input-group-addon"><span class="flag-code"><i class="en xe-flag"></i><!-- react-text: 18 -->en<!-- /react-text --></span></span></div></div></div></div></div><div class="form-group"><label>설명</label><div class="lang-editor-box"><div data-reactroot="" class="textarea"><input type="hidden" name="xe_use_request_preprocessor" value="Y"><input type="hidden" name="xe_lang_preprocessor://lang/seq/4/name" value="description"><input type="hidden" name="xe_lang_preprocessor://lang/seq/4/key" value=""><input type="hidden" name="xe_lang_preprocessor://lang/seq/4/multiline" value="true"><input type="hidden" name="description" value=""><div class="input-group"><textarea class="form-control" id="input-4-ko" name="xe_lang_preprocessor://lang/seq/4/locale/ko"></textarea><span class="input-group-addon"><span class="flag-code"><i class="ko xe-flag"></i><!-- react-text: 12 -->ko<!-- /react-text --></span></span></div><div class="sub"><div class="input-group"><textarea class="form-control" id="input-4-en" name="xe_lang_preprocessor://lang/seq/4/locale/en"></textarea><span class="input-group-addon"><span class="flag-code"><i class="en xe-flag"></i><!-- react-text: 19 -->en<!-- /react-text --></span></span></div></div></div></div></div></div><div class="panel-footer"><div class="pull-right"><button type="button" class="btn btn-default">닫기</button><button type="submit" class="btn btn-primary">저장</button></div></div>
    },
  };
})();
