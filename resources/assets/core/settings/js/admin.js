$(document).ready(function () {

    $(".dim").on('click', function () {
        $("aside").removeClass("open");
        $(".dim").hide()
        $("body").css("overflow", "");
		$("html").css("position", "");
    });

    $(".btn_slide").on('click', function (e) {
        // mobile
        if ($(window).innerWidth() < 768) {
            // close sidebar
            if ($('aside').hasClass("open")) {
                $("aside").removeClass("open");

            // open sidebar
            } else {
                $("aside").addClass("open");
                $(".dim").show()
                $("body").css("overflow", "hidden");
				$("html").css("position", "fixed");//딤드 밑으로 스크롤이 되지 않도록 설정 함
                //$(this).off('click');
            }
        // desktop
        } else {
            $('body').toggleClass("sidebar-collapse");
			
        }
    });

    $(document).on('click', function (event) {

        var $target = $(event.target);
        var $sub_depth = $target.parent('.sub_depth');
        var $ul = $($target).next('.sub_depth_lst');

        if ($ul.is(':visible')) {
            // 하위 depth 에 열려있는건 닫음
            $ul.find('.sub_depth_lst').slideUp('fast');
            $ul.find('.sub_depth').removeClass('open');

            $ul.slideUp('fast');
            $sub_depth.removeClass('open');

        } else {
            var $parent = $sub_depth.parent();
            // 동일 depth 에 열려있는건 닫음
            $parent.find('.sub_depth.open>.sub_depth_lst').slideUp('fast');
            $parent.find('.sub_depth.open').removeClass('open');

            $ul.slideDown('fast');
            $sub_depth.addClass('open');
        }
    });
})
