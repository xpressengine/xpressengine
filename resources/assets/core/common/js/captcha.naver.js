var naverReissue = function (i, k) {
  $.ajax({
    url: xeBaseURL + '/captcha/naver/reissue',
    type: 'get',
    dataType: 'json',
    success: function (json) {
      $(k).val(json.key);
      $(i).attr('src', json.img);
    },
  });
};
