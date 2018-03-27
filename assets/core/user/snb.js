jQuery(function ($) {
  $(window).resize(function () {
    // 화면 width 값
    var innerWidth2 = $(window).innerWidth()

    // 모바일 메뉴 노출 상태에서 화면이 커졌을 경우 헤더 메뉴 정상 노출을 위해 적용
    if (innerWidth2 > 768) {
      $('body').css('overflow', '')
      $('.snb').removeClass('open').css('left', '')
    }
  })
})
