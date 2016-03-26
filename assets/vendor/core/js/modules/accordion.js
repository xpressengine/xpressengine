define(function(XE) {

    var Accordion = {},
        $ = XE.$;

    /**
     * section 을 accordion 방식으로 처리
     */
    Accordion.accordionSection = function() {
        var selectors = $.AdminLTE.options.boxWidgetOptions.boxWidgetSelectors;
        $('.__xe_sections').each(function(index, element) {
            // load 된 순간은 다 닫음
            var container = $(element);

            var parsedUrl = XE.parseUrl();
            var hash = parsedUrl.hash;
            if (hash != '') {
                var activeBox = container.find('[data-hash="'+hash+'"]').parents('.box');
                if (activeBox.length > 0) {
                    Accordion.accordionSectionOpen(container, activeBox);
                }
            } else {
                // 하나는 열어 줌.
                hash = container.children('.box:first').find(selectors.collapse).data('hash');
            }
        }).on('click', selectors.collapse, function() {
            var button = $(this);
            var hash = button.data('hash');
            window.history.pushState(null, 'board-section-'.hash, hash);
            Accordion.accordionSectionClose(button.parents('.__xe_sections:first'), selectors.collapse, hash);
        });
    }

    /**
     * 박스 open
     * 상위 박스 모두 open
     *
     * @param container
     * @param box
     */
    Accordion.accordionSectionOpen = function(container, box) {
        // 내 상위에 box 가 있는지 체크
        var parentBox = container.parents('.box');

        if (parentBox.length > 0 ) {
            var parentContainer = parentBox.parents('.__xe_sections');
            Accordion.accordionSectionOpen(parentContainer, parentBox)
        }

        box.removeClass('collapsed-box');
    }

    /**
     * 박스 close
     *
     * @param box
     */
    Accordion.accordionSectionClose = function(cotainer, selector, hash) {
        cotainer.find(selector).each(function(index, element) {
            var button = $(element);
            // 동일 cotainer 가 아니면 pass
            if (button.parents('.__xe_sections:first').is(cotainer) === true) {
                var box = button.parents('.box:first');
                if (hash != button.data('hash')) {
                    box.addClass('collapsed-box');
                    box.find('.btn').children(":first").removeClass('fa-minus').addClass('fa-plus');
                    box.find("> .box-body, > .box-footer").slideUp(100);
                }
            }
        });
    };

    return Accordion;
}(XE));
