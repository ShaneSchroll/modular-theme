<?php
// This is the callback that renders the blocks created in [acf-block-functions.php]
function custom_block_callback( $block, $content = '', $is_preview = false ) {
	$context = Timber::get_context();

	$context['block'] = $block;
	$context['fields'] = get_fields();
	$context['is_preview'] = $is_preview;

	// templates/blocks/acf/BLOCK_NAME.twig
	$template = 'templates/blocks/' . $block['name'] . '.twig';
	Timber::render( $template, $context );
}