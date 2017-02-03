/**
 * @name		jQuery touchTouch plugin
 * @author		Martin Angelov
 * @version 	1.0
 * @url			http://tutorialzine.com/2012/04/mobile-touch-gallery/
 * @license		MIT License
 */
/*
 <div class="images" data-toggle="xe-lightbox" data-selector="img">
 <img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTgIjFUOm55lE51OyoHhVspKSF05Qm8uVTaf_huAwjmfC3yx87a"
 data-origin="http://flexslider.woothemes.com/images/kitchen_adventurer_caramel.jpg" width="120" height="120" alt="thumb">
 <img src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcQe3iQEWJnEaupbWiztj6CPA4BmB3TH0iKE4yhtauZlIjb64Ma9"
 data-origin="http://webdae.uta.cl/images/slide4.jpg" width="120" height="120" alt="thumb">
 <img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTShhpbR6qA84Ui3lqRczYKZCQzlozfmvmbRrs_9Gi-l9FT_tEw"
 data-origin="http://memocarilog.info/wp-content/uploads/2012/02/slides.png" width="120" height="120" alt="thumb">
 <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTbWJHOJ49A6b1TNuufXpPzZC2UcDHHMGHsNVJ9TozXYg2uRSpf"
 data-origin="http://www.fergusweb.net/wp-content/plugins/flexslider/images/inacup_samoa.jpg" width="120" height="120" alt="thumb">
 <img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcSxsb5rpIrnP97QdqwSA_UbeZXt1NlRI5T9Os4OiDx36JxGxfbR"
 data-origin="http://www.ie.edu/es/valores/images/mocks/inacup_donut.jpg" width="120" height="120" alt="thumb">
 <img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTgBFGmplPxC8V0RYiL1BNw0UnrJAmqy8mx96fh6FtM_i46oqk9"
 data-origin="http://pixelosaur.com/blog/wp-content/uploads/2015/01/flex-slider.png" width="120" height="120" alt="thumb">
 </div>

 $(selector).lightbox(options);
 */
(function ($) {
$.fn.lightbox = function (options) {

  var $overlay = $('<div id="xe-galleryOverlay">');
  var $slider = $('<div id="xe-gallerySlider">');
  var $prevArrow = $('<a id="xe-prevArrow"><i class="xi-angle-left-thin"></i></a>'); //버튼 영역 임시 제거 TODO 추후 추가되어야함.
  var $nextArrow = $('<a id="xe-nextArrow"><i class="xi-angle-right-thin"></i></a>');//버튼 영역 임시 제거 TODO 추후 추가되어야함.
  var $overlayClose = $('<button id="btn-overlay-close"><i class="xi-close"></i></button>');
  var $overlayVisible = false;
  var $placeholders = $([]);
  var index = 0;
  var $this = $(this);
  var targetSelector = $this.data('selector');
  var $items = targetSelector ? $this.find(targetSelector) : $this.find('img');

  // Appending the markup to the page
  $overlay.hide().appendTo('body');
  $slider.appendTo($overlay);

  // Creating a placeholder for each image
  $items.each(function () {
    $placeholders = $placeholders.add($('<div class="xe-placeholder">'));
  });

  // Hide the gallery if the background is touched / clicked
  $slider.append($placeholders).on('click', function (e) {
    // var $target = $(e.target);
    //
    // if ($target.hasClass('xe-placeholder')) {
    //   hideOverlay();
    // }
  });

  // Listen for touch events on the body and check if they
  // originated in #xe-gallerySlider img - the images in the $slider.
  $('body').on('touchstart', '#xe-gallerySlider img', function (e) {

    var touch = e.originalEvent;
    var startX = touch.changedTouches[0].pageX;

    $slider.on('touchmove', function (e) {

      e.preventDefault();

      touch = e.originalEvent.touches[0] ||
        e.originalEvent.changedTouches[0];

      if (touch.pageX - startX > 10) {

        $slider.off('touchmove');
        showPrevious();
      } else if (touch.pageX - startX < -10) {

        $slider.off('touchmove');
        showNext();
      }
    });

    // Return false to prevent image
    // highlighting on Android
    return false;

  }).on('touchend', function () {

    $slider.off('touchmove');

  });

  // Listening for clicks on the thumbnails
  $items.on('click', function (e) {

    e.preventDefault();

    var $this = $(this);
    var galleryName;
    var selectorType;
    var $closestGallery = $this.parent().closest('[data-gallery]');

    // Find gallery name and change $items object to only have
    // that gallery

    //If gallery name given to each item
    if ($this.attr('data-gallery')) {

      galleryName = $this.attr('data-gallery');
      selectorType = 'item';

      //If gallery name given to some ancestor
    } else if ($closestGallery.length) {

      galleryName = $closestGallery.attr('data-gallery');
      selectorType = 'ancestor';

    }

    //These statements kept seperate in case elements have data-gallery on both
    //$items and ancestor. Ancestor will always win because of above statments.
    if (galleryName && selectorType == 'item') {

      $items = $('[data-gallery=' + galleryName + ']');

    } else if (galleryName && selectorType == 'ancestor') {

      //Filter to check if item has an ancestory with data-gallery attribute
      $items = $items.filter(function () {

        return $(this).parent().closest('[data-gallery]').length;

      });

    }

    // Find the position of this image
    // in the collection
    index = $items.index(this);
    showOverlay(index);
    showImage(index);

    // Preload the next image
    preload(index + 1);

    // Preload the previous
    preload(index - 1);

  });

  // If the browser does not have support
  // for touch, display the arrows
  if (!('ontouchstart' in window)) {
    $overlay.append($prevArrow).append($nextArrow).append($overlayClose);

    $prevArrow.click(function (e) {
      e.preventDefault();
      showPrevious();
    });

    $nextArrow.click(function (e) {
      e.preventDefault();
      showNext();
    });

    $overlayClose.click(function (e) {
      hideOverlay();
    });
  }

  if (('ontouchstart' in window)) {
    $overlay.append($overlayClose);
    $overlayClose.click(function (e) {
      hideOverlay();
    });
  }

  // Listen for arrow keys
  $(window).bind('keydown', function (e) {

    if (e.keyCode == 37) {
      showPrevious();
    } else if (e.keyCode == 39) {
      showNext();
    } else if (e.keyCode == 27) { //esc
      hideOverlay();
    }

  });

  /* Private functions */

  function showOverlay(index) {
    // If the $overlay is already shown, exit
    if ($overlayVisible) {
      return false;
    }

    // Show the $overlay
    $overlay.show();

    setTimeout(function () {
      // Trigger the opacity CSS transition
      $overlay.addClass('visible');
    }, 100);

    // Move the $slider to the correct image
    offsetSlider(index);

    // Raise the visible flag
    $overlayVisible = true;
  }

  function hideOverlay() {
    // If the $overlay is not shown, exit
    if (!$overlayVisible) {
      return false;
    }

    // Hide the $overlay
    $overlay.hide().removeClass('visible');
    $overlayVisible = false;

    //Clear preloaded $items
    $('.placeholder').empty();

    //Reset possibly filtered $items
    $items = $this.find('>');
  }

  function offsetSlider(index) {
    // This will trigger a smooth css transition
    $slider.css('left', (-index * 100) + '%');
  }

  // Preload an image by its index in the $items array
  function preload(index) {
    setTimeout(function () {
      showImage(index);
    }, 1000);
  }

  // Show image in the $slider
  function showImage(index) {
    var $ele = $items.eq(index);
    var src = '';

    // If the index is outside the bonds of the array
    if (index < 0 || index >= $items.length) {
      return false;
    }

    // Call the load function with the href attribute of the item
    switch ($ele.get(0).tagName.toLowerCase()) {
      case 'img':
        src = $ele.data('origin') || $ele.attr('src');
      break;

      default:
        src = $ele.find('img').data('origin') || $ele.find('img').attr('src');
      break;
    }

    loadImage(src, function () {
      $placeholders.eq(index).html(this);
    });
  }

  // Load the image and execute a callback function.
  // Returns a jQuery object
  function loadImage(src, callback) {
    var img = $('<img>').on('load', function () {
      callback.call(img);
    });

    img.attr('src', src);
  }

  function showNext() {
    // If this is not the last image
    if (index + 1 < $items.length) {
      index++;
      offsetSlider(index);
      preload(index + 1);
    } else {
      // Trigger the spring animation
      $slider.addClass('rightSpring');
      setTimeout(function () {
        $slider.removeClass('rightSpring');
      }, 500);
    }
  }

  function showPrevious() {
    // If this is not the first image
    if (index > 0) {
      index--;
      offsetSlider(index);
      preload(index - 1);
    } else {
      // Trigger the spring animation
      $slider.addClass('leftSpring');
      setTimeout(function () {
        $slider.removeClass('leftSpring');
      }, 500);
    }
  }

  function reset() {
    $('#xe-galleryOverlay').remove();
    $this.lightbox();
  }

  return {
    reset: reset,
  };
};

$(function () {
  $('[data-toggle="xe-lightbox"]').each(function () {
    $(this).lightbox();
  });
});

})(jQuery);
