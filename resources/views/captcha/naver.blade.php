
<div class="naver-captcha">
    <p>{{ xe_trans('xe::enterAsShownInTheImage') }}</p>
    <img src="{{ $img }}" id="naver-captcha-image">
    <button type="button" class="btn-refresh" onclick="naverCaptchaReissue('#naver-captcha-image', '#naver-captcha-key');">{{ xe_trans('xe::refresh') }}</button>
    <input type="text" name="{{ $name }}" class="xe-form-control" placeholder="{{ xe_trans('xe::automaticInputTextPrevention') }}">
    <input type="hidden" id="naver-captcha-key" name="key" value="{{ $key }}">
</div>

<script>
  function naverCaptchaReissue (elImage, elKey) {
    window.XE.get(window.XE.baseURL + '/captcha/naver/reissue')
      .then(function (response) {
        window.jQuery(elKey).val(response.data.key)
        window.jQuery(elImage).attr('src', response.data.img)
      })
  }
</script>
