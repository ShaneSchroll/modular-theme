// Author: Shane Schroll
(function($) {
    $(document).ready(function() {

		$(function noticeBanner() {
			$('.notice-banner .close-notice').on('click', function() {
				$(this).parent().hide();
			});
            // maybe add cookies to keep it closed on subsequent visits
		});

	});
})(jQuery);