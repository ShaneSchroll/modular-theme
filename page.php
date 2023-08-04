<?php
// Default Template
$context = Timber::get_context();
$post = Timber::get_post();
$context['post'] = $post;
$templates = ['pages/page.twig'];
Timber::render( $templates, $context );