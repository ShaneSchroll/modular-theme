<?php
$labels = [
	'name'                => __( 'RENAME', 'mod' ),
	'singular_name'       => __( 'RENAME Post', 'mod' ),
	'add_new'             => _x( 'Add RENAME', 'mod', 'mod' ),
	'add_new_item'        => __( 'Add RENAME', 'mod' ),
	'edit_item'           => __( 'Edit RENAME', 'mod' ),
	'new_item'            => __( 'Add RENAME', 'mod' ),
	'view_item'           => __( 'View RENAME', 'mod' ),
	'search_items'        => __( 'Search RENAME', 'mod' ),
	'not_found'           => __( 'No RENAME found', 'mod' ),
	'not_found_in_trash'  => __( 'No RENAME found in Trash', 'mod' ),
	'parent_item_colon'   => __( 'Parent RENAME:', 'mod' ),
	'menu_name'           => __( 'RENAME', 'mod' ),
];

$args = [
	'labels'              => $labels,
	'hierarchical'        => false,
	'description'         => '',
	'taxonomies'          => [ 'RENAME-tax' ],
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
register_post_type( 'RENAME', $args );

// setup taxonomies
$tax_labels = [
	'name' 				=> _x( 'RENAME Categories', 'mod' ),
	'singular_name' 	=> _x( 'RENAME Category', 'mod' ),
	'search_items' 		=> __( 'Search RENAME Categories', 'mod' ),
	'all_items' 		=> __( 'All RENAME Categories', 'mod' ),
	'edit_item' 		=> __( 'Edit RENAME Category', 'mod' ),
	'update_item' 		=> __( 'Update RENAME Category', 'mod' ),
	'add_new_item' 		=> __( 'Add RENAME Category', 'mod' ),
	'new_item_name' 	=> __( 'Create RENAME Category', 'mod' ),
	'menu_name' 		=> __( 'RENAME Categories', 'mod' ),
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
register_taxonomy( 'RENAME-tax', 'RENAME', $tax_args );