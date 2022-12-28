// Shane Schroll
(function($) {
    $(document).ready(function() {

		let $document = $(document);

		$(function noticeBanner() {
			// notice close function
			$('.notice-banner .close-notice').on('click', function() {
				$(this).parent().hide();
			});
		});

		// Datatables setup - https://datatables.net/manual/
		$table = $('.datatable');
		$table.DataTable();

		$(function customFacetSettings() {
			// show a loading symbol for filters once the dataset becomes larger
			$document.on('facetwp-refresh', function() {
				$('.facetwp-template').prepend('<div class="is-loading"><span class="is-loading__icon"></span></div>');
			});

			// // once a search is made, filtering turns into a "live filter"
			$document.on('facetwp-loaded', function() {
				$('.facetwp-template .is-loading').remove();
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
				$(this).toggleClass('chevron-rotate');
			});
		});
	}); // end Document.Ready
})(jQuery);