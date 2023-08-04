<?php

// change 'views' directory to 'templates'
Timber::$locations = __DIR__ . '/templates';

class MODSite extends TimberSite {

	/**
	 * To add items to the site class, first add an action hook to the constructor, plus your custom function name
	 * then create your function outside of the constructor

	 * To add global actions or filters, put both the hook and function outside of this site class
	*/

	function __construct() {
		// Actions //
		add_action( 'after_setup_theme', [ $this, 'after_setup_theme' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'admin_head', [ $this, 'admin_head_css' ] );
		add_action( 'admin_menu', [ $this, 'admin_menu_cleanup'] );
		add_action( 'init', [ $this, 'register_post_types' ] );
		add_action( 'login_enqueue_scripts', [ $this, 'style_login' ] );
		add_action( 'acf/init', [ $this, 'render_custom_acf_blocks' ] );

		// Filters //
		add_filter( 'timber_context', [ $this, 'add_to_context' ] );
		add_filter( 'block_categories', [ $this, 'mod_block_category' ], 10, 2 );
		add_filter( 'manage_pages_columns', [ $this, 'remove_pages_count_columns'] );

		parent::__construct();
	}

	// hide WP update nag
	function admin_head_css() {
		?>
		<style type="text/css">
			.update-nag,
			#wp-admin-bar-comments,
			#adminmenu #collapse-menu,
			#wp-admin-bar-wp-logo  { display: none !important; }
		</style>
		<?php
	}

	// WP admin login styles
	function style_login() {
		?>
		<style type="text/css">
			#login h1, .login h1 {
				background-color: white;
				padding: 1.5rem 0.5rem;
				border-radius: 3px;
			}

			#login h1 a, .login h1 a {
				background-image: url('<?= get_stylesheet_directory_uri() . '/static/images/screenshot.jpg' ?>') !important;
				background-position: center;
				width: 10rem;
				background-size: contain;
				padding: 1rem;
				margin: 0 auto;
			}
		</style>
		<?php
	}

	// enqueue styles & scripts
	function enqueue_scripts() {
		$version = filemtime( get_stylesheet_directory() . '/style.css' );
		wp_enqueue_style( 'core-css', get_stylesheet_directory_uri() . '/style.css', [], $version );
		wp_enqueue_style( 'block-css', get_stylesheet_directory_uri() . '/custom-blocks.css', [], $version );
		wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/assets/js/slick.min.js', ['jquery'], '1.8.1' );
		wp_enqueue_script( 'mfp-js', get_template_directory_uri() . '/assets/js/mfp.min.js', ['jquery'], '1.1.0' );
		wp_enqueue_script( 'datatables-js', get_template_directory_uri() . '/assets/js/datatables.js', ['jquery'], '1.13.1' );
		wp_enqueue_script( 'mod-js', get_template_directory_uri() . '/assets/js/site-dist.js', ['jquery', 'slick-js', 'mfp-js', 'datatables-js'], $version );
		wp_enqueue_script( 'theme-editor', get_template_directory_uri() . '/assets/js/editor.js', [], $version );
	}

	// Custom context helper functions (callable)
	function add_to_context( $context ) {
		$context['site']           = $this;
		$context['date']           = date( 'F j, Y' );
		$context['date_year']      = date( 'Y' );
		$context['options']        = get_fields( 'option' );
		$context['home_url']       = home_url( '/' );
		$context['is_front_page']  = is_front_page();
		$context['is_singular']    = is_singular();
		$context['get_url']        = $_SERVER['REQUEST_URI'];

		return $context;
	}

	// Menus / Theme Support / ACF Options Page
	function after_setup_theme() {
		add_theme_support( 'menus' );
		register_nav_menu( 'primary', 'Top Navigation' );
		register_nav_menu( 'secondary', 'Footer Navigation' );

		add_theme_support( 'align-wide' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'custom-blocks.css' );
		add_theme_support( 'disable-custom-colors' );

		// create option pages for things like footer data and company info/logos
		if( function_exists( 'acf_add_options_page' ) ) {
			$parent = acf_add_options_page([
				'page_title'      => 'Main Options',
				'menu_title'      => 'Theme Options',
				'capability'      => 'edit_posts',
				'redirect'        => false,
				'icon_url'		  => 'dashicons-database-view',
				'position'		  => 2,
				'updated_message' => 'Updated.',
			]);

			// Notification Banner Setup
			$child = acf_add_options_sub_page([
				'page_title'  => __( 'Notification Banner' ),
				'menu_title'  => __( 'Notice Banner' ),
				'parent_slug' => $parent['menu_slug'],
			]);

			// Contact Settings
			$child = acf_add_options_sub_page([
				'page_title'  => __( 'Contact Settings' ),
				'menu_title'  => __( 'Contact' ),
				'parent_slug' => $parent['menu_slug'],
			]);

			// Social Settings
			$child = acf_add_options_sub_page([
				'page_title'  => __( 'Social Settings' ),
				'menu_title'  => __( 'Social' ),
				'parent_slug' => $parent['menu_slug'],
			]);
		}
	}

	// registers and renders our custom acf blocks
	function render_custom_acf_blocks() {
		require 'custom-block-functions.php';
	}

	// creates a custom block category for our theme-specific blocks
	function mod_block_category( $categories, $post ) {
		return array_merge(
			$categories, [
				[
					'slug'  => 'mod-blocks',
					'title' => 'Custom Blocks',
				],
			]
		);
	}

	// include post types
	function register_post_types() {
		include_once('custom-post-types/post-type-rename.php');
	}

	// remove unused items from admin menu
	// to show Posts and Comments Admin Pages - delete this function and the action hook
	function admin_menu_cleanup() {
		remove_menu_page( 'edit.php' ); // Posts
		remove_menu_page( 'edit-comments.php' ); // Comments
	}

	// removed comment column from posts pages
	// to show comment counts - delete this function and the action hook
	function remove_pages_count_columns( $defaults ) {
		unset($defaults['comments']);
		return $defaults;
	}
} // End of MODSite class

new MODSite();

// primary site navigation
function mod_render_primary_menu() {
	wp_nav_menu([
		'theme_location' => 'primary',
		'container'      => false,
		'menu_id'        => 'primary-menu',
	]);
}

// secondary site navigation
function mod_render_secondary_menu() {
	wp_nav_menu([
		'theme_location' => 'secondary',
		'container'      => false,
		'menu_id'        => 'secondary-menu',
	]);
}