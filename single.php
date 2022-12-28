<?php

$context = Timber::get_context();
$post = Timber::get_post();
$context['post'] = $post;

// allow more granular control between parent and child posts
if( is_singular() ) :
	if( $post->post_parent != 0 ) {
		$context['is_child'] = true;
	} else {
		$context['is_parent'] = true;
	}
endif;

the_post();

Timber::render(['single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig'], $context);