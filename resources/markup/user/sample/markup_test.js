$(document).ready(function(){
  $(".xe-menu-toggle").click(function(){
      $(".snb-list").toggle();
  });
  $(window).resize(function() {
    var innerWidth; // 화면 width 값

    innerWidth = $(window).innerWidth();
    // 모바일 메뉴 노출 상태에서 화면이 커졌을 경우 snb-list가 정상 노출을 위해 적용
    if(innerWidth > 768) {
        $(".snb-list").css("display",'');
    }
  });
})
