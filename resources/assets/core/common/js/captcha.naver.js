// @FIXME 이동
// @FIXME i? k?
var naverReissue = function (i, k) {
  window.XE.ajax({
    url: window.XE.Router.baseURL + '/captcha/naver/reissue',
    type: 'get',
    dataType: 'json',
    success: function (json) {
      window.jQuery(k).val(json.key)
      window.jQuery(i).attr('src', json.img)
    }
  })
}
