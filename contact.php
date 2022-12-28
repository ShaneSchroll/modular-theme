<?php
// Template Name: Contact Template
$context = Timber::get_context();
$post = Timber::get_post();
$context['post'] = $post;
$templates = ['pages/contact.twig'];
Timber::render( $templates, $context );