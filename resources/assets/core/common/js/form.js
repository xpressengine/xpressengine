// @FIXME ui-component로 이동
// xe radio button
(function ($) {
  $('.__xe_radio')
    .on('change', 'input', function () {
      $('.__xe_radio input').trigger('xe.radio.change')
      return false
    })
    .on('xe.radio.change', 'input', function () {
      var $this = $(this)
      if ($this.is(':checked')) {
        $this.parent('.__xe_radio').addClass('on')
      } else {
        $this.parent('.__xe_radio').removeClass('on')
      }
    })
}(window.jQuery))
