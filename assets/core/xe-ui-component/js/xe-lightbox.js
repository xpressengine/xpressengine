/**
 * @name    jQuery touchTouch plugin
 * @author    Martin Angelov
 * @version  1.0
 * @url      http://tutorialzine.com/2012/04/mobile-touch-gallery/
 * @license    MIT License
 */

/*
 <div class="thumbs">
 <a href="http://owlgraphic.com/owlcarousel/demos/assets/fullimage1.jpg"><img src="http://owlgraphic.com/owlcarousel/demos/assets/fullimage1.jpg" width="120" height="120" alt="thumb"></a>
 <a href="http://getuikit.com/docs/images/placeholder_800x600_3.jpg"><img src="http://getuikit.com/docs/images/placeholder_800x600_3.jpg" width="120" height="120" alt="thumb"></a>
 <a href="http://owlgraphic.com/owlcarousel/demos/assets/fullimage3.jpg"><img src="http://owlgraphic.com/owlcarousel/demos/assets/fullimage3.jpg" width="120" height="120" alt="thumb"></a>
 <a href="http://www.responsibletravel.co.kr/travel/layouts/ts_basic/img/bg_nanum.jpg"><img src="http://www.responsibletravel.co.kr/travel/layouts/ts_basic/img/bg_nanum.jpg" width="120" height="120" alt="thumb"></a>
 <a href="http://getuikit.com/docs/images/placeholder_800x600_3.jpg"><img src="http://getuikit.com/docs/images/placeholder_800x600_3.jpg" width="120" height="120" alt="thumb"></a>
 <a href="http://owlgraphic.com/owlcarousel/demos/assets/fullimage3.jpg"><img src="http://owlgraphic.com/owlcarousel/demos/assets/fullimage3.jpg" width="120" height="120" alt="thumb"></a>
 </div>

 $(selector).lightbox(options);

 */
(function($) {

	var overlay = $('<div id="xe-galleryOverlay">');
	var slider = $('<div id="xe-gallerySlider">');
	var prevArrow = $('<a id="xe-prevArrow"><i class="xi-angle-left-thin"></i></a>');
	var nextArrow = $('<a id="xe-nextArrow"><i class="xi-angle-right-thin"></i></a>');
	var overlayClose = $('<button id="btn-overlay-close"><i class="xi-close"></i></button>');
	var overlayVisible = false;

	$.fn.lightbox = function(options) {
		var placeholders = $([]);
		var index = 0;
		var allitems = this;
		var items = allitems;

		// Appending the markup to the page
		overlay.hide().appendTo('body');
		slider.appendTo(overlay);

		// Creating a placeholder for each image
		items.each(function() {
			placeholders = placeholders.add($('<div class="xe-placeholder">'));
		});

		// Hide the gallery if the background is touched / clicked
		slider.append(placeholders).on('click', function(e) {

			//if(!$(e.target).is('img')){
			//	hideOverlay();
			//}
		});

		// Listen for touch events on the body and check if they
		// originated in #xe-gallerySlider img - the images in the slider.
		$('body').on('touchstart', '#xe-gallerySlider img', function(e) {

			var touch = e.originalEvent,
					startX = touch.changedTouches[0].pageX;

			slider.on('touchmove', function(e) {

				e.preventDefault();

				touch = e.originalEvent.touches[0] ||
						e.originalEvent.changedTouches[0];

				if (touch.pageX - startX > 10) {

					slider.off('touchmove');
					showPrevious();
				} else if (touch.pageX - startX < -10) {

					slider.off('touchmove');
					showNext();
				}
			});

			// Return false to prevent image
			// highlighting on Android
			return false;

		}).on('touchend', function() {

			slider.off('touchmove');

		});

		// Listening for clicks on the thumbnails
		items.on('click', function(e) {

			e.preventDefault();

			var $this = $(this),
					galleryName,
					selectorType,
					$closestGallery = $this.parent().closest('[data-gallery]');

			// Find gallery name and change items object to only have
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
			//items and ancestor. Ancestor will always win because of above statments.
			if (galleryName && selectorType == 'item') {

				items = $('[data-gallery=' + galleryName + ']');

			} else if (galleryName && selectorType == 'ancestor') {

				//Filter to check if item has an ancestory with data-gallery attribute
				items = items.filter(function() {

					return $(this).parent().closest('[data-gallery]').length;

				});

			}

			// Find the position of this image
			// in the collection
			index = items.index(this);
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
			overlay.append(prevArrow).append(nextArrow).append(overlayClose);

			prevArrow.click(function(e) {
				e.preventDefault();
				showPrevious();
			});

			nextArrow.click(function(e) {
				e.preventDefault();
				showNext();
			});

			overlayClose.click(function(e) {
				hideOverlay();
			});
		}

		if (('ontouchstart' in window)) {
			overlay.append(overlayClose);
			overlayClose.click(function(e) {
				hideOverlay();
			});
		}

		// Listen for arrow keys
		$(window).bind('keydown', function(e) {

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
			// If the overlay is already shown, exit
			if (overlayVisible) {
				return false;
			}

			// Show the overlay
			overlay.show();

			setTimeout(function() {
				// Trigger the opacity CSS transition
				overlay.addClass('visible');
			}, 100);

			// Move the slider to the correct image
			offsetSlider(index);

			// Raise the visible flag
			overlayVisible = true;
		}

		function hideOverlay() {

			// If the overlay is not shown, exit
			if (!overlayVisible) {
				return false;
			}

			// Hide the overlay
			overlay.hide().removeClass('visible');
			overlayVisible = false;

			//Clear preloaded items
			$('.placeholder').empty();

			//Reset possibly filtered items
			items = allitems;
		}

		function offsetSlider(index) {

			// This will trigger a smooth css transition
			slider.css('left', (-index * 100) + '%');
		}

		// Preload an image by its index in the items array
		function preload(index) {

			setTimeout(function() {
				showImage(index);
			}, 1000);
		}

		// Show image in the slider
		function showImage(index) {

			var $ele = items.eq(index);
			var src = '';

			// If the index is outside the bonds of the array
			if (index < 0 || index >= items.length) {
				return false;
			}

			// Call the load function with the href attribute of the item
			switch ($ele.get(0).tagName.toLowerCase()) {
				case 'img':
					src = $ele.attr('src');
					break;

				default:
					src = $ele.find('img').attr('src');
					break;

			}

			loadImage(src, function() {
				placeholders.eq(index).html(this);
			});
		}

		// Load the image and execute a callback function.
		// Returns a jQuery object

		function loadImage(src, callback) {

			var img = $('<img>').on('load', function() {
				callback.call(img);
			});

			img.attr('src', src);
		}

		function showNext() {

			// If this is not the last image
			if (index + 1 < items.length) {
				index++;
				offsetSlider(index);
				preload(index + 1);
			} else {
				// Trigger the spring animation
				slider.addClass('rightSpring');
				setTimeout(function() {
					slider.removeClass('rightSpring');
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
				slider.addClass('leftSpring');
				setTimeout(function() {
					slider.removeClass('leftSpring');
				}, 500);
			}
		}
	};

	$(function() {
		$('[data-toggle="xe-lightbox"]').each(function() {
			var selector = $(this).data('selector');

			$(this).find(' > ' + selector).lightbox();
		});
	});

})(jQuery);
