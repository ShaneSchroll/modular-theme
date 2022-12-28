<?php
// There is no index.twig file. This file is required for WP to work properly, but is not utilized on the frontend.
// This file sets up Context and Template functions that can be used on all templates and pages.
$context = Timber::get_context();
$post = Timber::get_post();
$context['post'] = $post;
$templates = ['index.twig'];
Timber::render( $templates, $context );