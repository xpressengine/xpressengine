// @FIXME 이동
// @FIXME i? k?
var naverReissue = function (i, k) {
  window.jQuery.ajax({
    url: window.xeBaseURL + '/captcha/naver/reissue',
    type: 'get',
    dataType: 'json',
    success: function (json) {
      window.jQuery(k).val(json.key)
      window.jQuery(i).attr('src', json.img)
    }
  })
}
