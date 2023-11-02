// Author: Shane Schroll
(function($) {
    $(document).ready(function() {

		$(function noticeBanner() {
			// notice close function
			$('.notice-banner .close-notice').on('click', function() {
				$(this).parent().hide();
			});
		});

		// accessible accordion block - controls and aria events for screenreaders
		$(function accordionBlock() {
			$('.accordion-content').each(function() {
				$(this).hide();
			});

			$('.accordion-block-title').on('click', function() {
				var $this = $(this);
				// fires on first click (content is expanded)
				if( $this.hasClass('target') ) {
					$this.removeClass('target');
					$this.attr('aria-pressed', 'true');
					$this.next('.accordion-content').slideToggle(350);
					$this.next('.accordion-content').attr('aria-expanded', 'true');
				} else {
					// fires on second click (content is closed)
					$this.next('.accordion-content:first').slideToggle(350, function() {
						$this.prev('.accordion-block-title').addClass('target');
						$this.prev('.accordion-block-title').attr('aria-pressed', 'false');
						$this.attr('aria-expanded', 'false');
					});
				}
				// always fire
				$(this).toggleClass('plus-rotate');
			});
		});
	}); // end Document.Ready
})(jQuery);