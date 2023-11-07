<?php

// Load Timber
require_once(__DIR__ . '/vendor/autoload.php');

// Initialize timber
Timber\Timber::init();

// Tell Timber where to load twig files from
Timber::$locations = __DIR__ . '/templates';

class MODSite extends Timber\Site {

	// site class constructor
	function __construct() {
		// Actions //
		add_action( 'after_setup_theme', [$this, 'after_setup_theme'] );
		add_action( 'wp_enqueue_scripts', [$this, 'mod_enqueue_scripts'] );
		add_action( 'admin_head', [$this, 'admin_head_css'] );
		add_action( 'admin_menu', [$this, 'admin_menu_cleanup'] );
		add_action( 'admin_init', [$this, 'mod_no_trackbacks'] );
		add_action( 'init', [$this, 'register_post_types'] );
		add_action( 'login_enqueue_scripts', [$this, 'style_login'] );
		add_action( 'acf/init', [$this, 'render_custom_acf_blocks'] );
		add_action( 'enqueue_block_editor_assets', [$this, 'mod_enqueue_editor_scripts'] );

		if( is_admin_bar_showing() ) {
			remove_action( 'admin_bar_menu', [$this, 'wp_admin_bar_comments_menu'], 60 );
		}

		// Custom Filters //
		add_filter( 'timber_context', [$this, 'add_to_context'] );
		add_filter( 'block_categories', [$this, 'mod_block_category'], 10, 2 );
		add_filter( 'manage_pages_columns', [$this, 'remove_pages_count_columns'] );

		// General Filters //
		add_filter( 'comments_open', '__return_false', 20, 2 );
		add_filter( 'pings_open', '__return_false', 20, 2 );

		parent::__construct();
	}

	function mod_no_trackbacks() {
		foreach( get_post_types() as $post_type ) {
			if( post_type_supports($post_type, 'comments') ) {
				remove_post_type_support($post_type, 'comments');
				remove_post_type_support($post_type, 'trackbacks');
			}
		}
	}

	// hide elements in admin
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

	// admin login styles
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
	function mod_enqueue_scripts() {
		$version = filemtime( get_stylesheet_directory() . '/style.css' );
		wp_enqueue_style( 'mod-css', get_stylesheet_directory_uri() . '/style.css', [], $version );
		wp_enqueue_script( 'mod-js', get_template_directory_uri() . '/assets/js/site-dist.js', ['jquery'], $version );

		if( ! is_admin() ) {
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'wp-block-library-theme' );
		}
	}

	// enqueue block editor styles
	function mod_enqueue_editor_scripts() {
		$version = filemtime( get_stylesheet_directory() . '/custom-blocks.css' );
		wp_enqueue_style( 'mod-editor-css', get_stylesheet_directory_uri() . '/custom-blocks.css', [], $version );
	}

	// Custom context helper functions
	function add_to_context( $context ) {
		$context['site']           = $this;
		$context['date']           = date('F j, Y');
		$context['date_year']      = date('Y');
		$context['home_url']       = home_url('/');
		$context['is_front_page']  = is_front_page();
		$context['is_singular']    = is_singular();
		$context['get_url']        = $_SERVER['REQUEST_URI'];

		return $context;
	}

	// Menus / Theme Support / ACF Options Page
	function after_setup_theme() {
		add_theme_support( 'menus' );
		register_nav_menu( 'primary', 'Primary Navigation' );

		add_theme_support( 'align-wide' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'custom-blocks.css' );
		add_theme_support( 'disable-custom-colors' );

		// create an acf option page section
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
		}
	}

	// registers and renders our custom acf blocks
	function render_custom_acf_blocks() {
		require 'custom-block-functions.php';
	}

	// create a custom block category for our theme-specific blocks
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
	function admin_menu_cleanup() {
		remove_menu_page( 'edit.php' ); // Posts
		remove_menu_page( 'edit-comments.php' ); // Comments
	}

	// removed comment column from posts pages
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

// disable jQuery Migrate
function mod_disable_jqmigrate($scripts) {
	if( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
		$script = $scripts->registered['jquery'];

		if( $script->deps ) {
			$script->deps = array_diff( $script->deps, ['jquery-migrate'] );
		}
	}
}
add_action( 'wp_default_scripts', 'mod_disable_jqmigrate' );