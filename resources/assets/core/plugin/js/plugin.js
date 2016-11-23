$(document).ready(function () {

  varswiper = new Swiper('.swiper', {
    pagination: '.swiper-pagination',
    paginationClickable: true,
    spaceBetween: 30,
    spaceBetween: 0,
    loop: true,
  });

  $('.swiper-button-prev').on('click', function (e) {
    e.preventDefault();
    swiper1.swipePrev();
  });

  $('.swiper-button-next').on('click', function (e) {
    e.preventDefault();
    swiper1.swipeNext();
  });

  $('.swiper').hover(function () {
    $('.swiper-button-white').animate({ opacity: 1 }, 250);
  }, function () {

    $('.swiper-button-white').animate({ opacity: 0 }, 250);
  });

});
