<?php
// Template Name: Documents Template
$context = Timber::get_context();
$post = Timber::get_post();
$context['post'] = $post;
$templates = ['pages/documents.twig'];
Timber::render( $templates, $context );