<?php
$labels = [
	'name'                => __( 'Rename', 'mod' ),
	'singular_name'       => __( 'News Post', 'mod' ),
	'add_new'             => _x( 'Add News', 'mod', 'mod' ),
	'add_new_item'        => __( 'Add News', 'mod' ),
	'edit_item'           => __( 'Edit News', 'mod' ),
	'new_item'            => __( 'Add News', 'mod' ),
	'view_item'           => __( 'View News', 'mod' ),
	'search_items'        => __( 'Search News', 'mod' ),
	'not_found'           => __( 'No News found', 'mod' ),
	'not_found_in_trash'  => __( 'No News found in Trash', 'mod' ),
	'parent_item_colon'   => __( 'Parent News:', 'mod' ),
	'menu_name'           => __( 'Rename', 'mod' ),
];

$args = [
	'labels'              => $labels,
	'hierarchical'        => false,
	'description'         => 'Posts.',
	'taxonomies'          => [ 'rename-tax' ],
	'public'              => true,
	'show_ui'             => true,
	'show_in_menu'        => true,
	'show_in_admin_bar'   => true,
	'show_in_rest'		  => true,
	'menu_position'       => null,
	'menu_icon'           => 'dashicons-carrot',
	'show_in_nav_menus'   => true,
	'publicly_queryable'  => true,
	'exclude_from_search' => false,
	'has_archive'         => false,
	'query_var'           => true,
	'can_export'          => true,
	'rewrite'             => true,
	'capability_type'     => 'post',
	'supports'            => [ 'title', 'thumbnail', 'editor' ]
];
register_post_type( 'rename', $args );

// setup taxonomies
$tax_labels = [
	'name' 				=> _x( 'News Categories', 'mod' ),
	'singular_name' 	=> _x( 'News Category', 'mod' ),
	'search_items' 		=> __( 'Search News Categories', 'mod' ),
	'all_items' 		=> __( 'All News Categories', 'mod' ),
	'edit_item' 		=> __( 'Edit News Category', 'mod' ),
	'update_item' 		=> __( 'Update News Category', 'mod' ),
	'add_new_item' 		=> __( 'Add News Category', 'mod' ),
	'new_item_name' 	=> __( 'Create News Category', 'mod' ),
	'menu_name' 		=> __( 'News Categories', 'mod' ),
	'parent_item'		=> __( 'Category Parent', 'mod' ),
];

$tax_args = [
	'hierarchical' 	    => true,
	'labels' 	    	=> $tax_labels,
	'show_ui' 	    	=> true,
	'show_admin_column' => true,
	'has_archive'		=> false,
	'query_var'	    	=> true,
	'show_in_rest'		=> true,
	'rewrite'			=> true,
];
register_taxonomy( 'rename-tax', 'rename', $tax_args );