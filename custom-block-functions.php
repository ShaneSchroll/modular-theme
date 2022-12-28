<?php
// This functions file is for all custom blocks added via ACF
// Reference: https://www.advancedcustomfields.com/resources/acf_register_block_type/

if( function_exists('acf_register_block_type') ) :
	include 'custom-block-callback.php'; // pass-off to let Timber render the blocks

	// accessible and dynamic accordion block
	$accordion_block = [
		'name' => 'accordion-block',
		'title' => __( 'Accordion Block', 'mod' ),
		'description' => __( 'Creates an accordion; The content is folded into the title.', 'mod' ),
		'render_callback' => 'custom_block_callback',
		'category' => 'mod-blocks',
		'align' => 'wide',
		'icon' => 'insert',
		'mode' => 'auto',
		'supports' => [ 'mode' => true ],
		'keywords' => [ 'block', 'drop', 'down', 'dropdown', 'accordion' ]
	];
	acf_register_block_type( $accordion_block );

	// accessible and inline button block
	$button_block = [
		'name' => 'button-block',
		'title' => __( 'Button Block', 'mod' ),
		'description' => __( 'Creates an inline button with text/background colors of your choice. Limited to colors within the theme for consistency.', 'mod' ),
		'render_callback' => 'custom_block_callback',
		'category' => 'mod-blocks',
		'align' => 'wide',
		'icon' => 'insert',
		'mode' => 'auto',
		'supports' => [ 'mode' => true ],
		'keywords' => [ 'block', 'button', 'a', 'href', 'link', 'url' ]
	];
	acf_register_block_type( $button_block );
endif;