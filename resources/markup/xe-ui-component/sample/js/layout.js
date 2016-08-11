$(document).ready(function(){

  $(window).resize(function() {
    var innerWidth; // 화면 width 값

    innerWidth = $(window).innerWidth();
    // 모바일 메뉴 노출 상태에서 화면이 커졌을 경우 헤더 메뉴 정상 노출을 위해 적용
    if(innerWidth > 768) {
      $('.sub-menu .sub-menu-list').css("display","");
      $(".dim").hide()
      $("body").css("overflow", "");
    }
  });

  $(".dim").on('click', function () {
    $(".dim").hide()
    $("body").css("overflow", "");
    $(".snb").removeClass("open");
  });

  $(".btn-slide").on('click', function (e) {
    // mobile
    if ($(window).innerWidth() < 1068) {
      // close sidebar

      if ($('.snb').hasClass("open")) {
        $(".snb").removeClass("open");
        // open sidebar
      } else {
        $(".snb").addClass("open");
        $(".dim").show()
        $("body").css("overflow", "hidden");
      }
    } else {

    }
  });

  $(document).on('click', function(event) {
    var $target = $(event.target);
    var $submenu = $target.parent('.sub-menu');
    var $main_skin = $target.parent('body.main-skin');
    var $ulwrap = $target.next('.sub-wrap');
    var $ul = $ulwrap.children('.sub-menu-list');

    if ($(window).innerWidth() < 992) {
      if ($submenu.length !== 0) {
       event.preventDefault();
       if ($ul.is(':visible')) {
          // 하위 sub-menu 에 열려있는건 닫음
          $ul.find('.sub-menu-list').slideUp('fast');
          $ul.find('.sub-menu').removeClass('open');
          $ul.slideUp('fast');
          $submenu.removeClass('open');
        } else {
          var $parent =$submenu.parent();
          // 동일 sub-menu 에 열려있는건 닫음
          $parent.find('.sub-menu.open>.sub-menu-list').slideUp('fast');
          $parent.find('.sub-menu.open').removeClass('open');
          $ul.slideDown('fast');
          $submenu.addClass('open');
        }
      } else {
        $('.sub-menu').removeClass('open')
        $('.sub-menu-list').slideUp('fast');
      }
    }else {
      if ($submenu.length !== 0) {
        // 타겟의 부모가 서브메뉴를 갖고 있는 경우
        event.preventDefault();
        if ($ul.is(':visible')) {
          // 열려있는건 닫음
          $ul.find('.sub-menu').removeClass('open');
          $submenu.removeClass('open');
        }else {
          // 동일 sub-menu 에 열려있는건 닫음
          var $parent =$submenu.parent();
          $parent.find('.sub-menu.open').removeClass('open');
          $parent.find('.sub-menu.open-fixed').addClass('open-temp');
          $parent.find('.sub-menu.open-fixed').removeClass('open-fixed');
          $submenu.addClass('open');
          $('.snb').addClass('depth-open');
        }
      } else {
        // 타겟의 부모가 서브메뉴가 아닌 경우 (document)
        $('.sub-menu.open').removeClass('open');
        $('.sub-menu.open-temp').addClass('open-fixed');
        $(' .snb').removeClass('depth-open');
      }
    }
  });
})
