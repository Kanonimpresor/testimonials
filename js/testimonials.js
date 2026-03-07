/**
 * Testimonials Plugin — Royal Bus
 * Toggle truncated text (Read more / Read less)
 * Updated for Bootstrap 5 + FontAwesome 5
 */
(function ($) {
    'use strict';

    $(document).ready(function () {
        var $section = $('.testimonials-section');
        var readMoreLabel = $section.data('readmore') || 'Read more';
        var readLessLabel = $section.data('readless') || 'Read less';

        $('.truncated').hide()
            .after('<span class="tm-toggle-more" role="button" tabindex="0" aria-label="' + readMoreLabel + '"><i class="fas fa-plus-circle" aria-hidden="true"></i></span>')
            .next('.tm-toggle-more').on('click keypress', function (e) {
                if (e.type === 'keypress' && e.which !== 13) return;
                var $icon = $(this).find('i');
                var isExpanded = $icon.hasClass('fa-minus-circle');
                $icon.toggleClass('fa-plus-circle fa-minus-circle');
                $(this).attr('aria-label', isExpanded ? readMoreLabel : readLessLabel);
                $(this).prev('.truncated').slideToggle(300);
            });
    });
})(jQuery);
