<?php
/**
 * func files
 */

// helpers
define('THEME_DIR', get_template_directory_uri() );

// setup
function gamelounge_setup() {

	load_theme_textdomain( 'gamelunge', get_template_directory() . '/languages' );

	// add theme support
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			//'search-form',
			//'comment-form',
			//'comment-list',
			//'gallery',
			//'caption',
			'style',
			'script',
		)
	);

}
add_action( 'after_setup_theme', 'gamelounge_setup' );


// style and scripts
add_action('wp_enqueue_scripts', function()  {
	wp_enqueue_style( 'game-style', THEME_DIR . '/style.css' );
	wp_enqueue_script( 'game-script', THEME_DIR . '/src/js/app.js', [], false, true );
	// add Bootstrap
	// wp_enqueue_style( 'bootstrap-css', 'URL', '');
	// wp_enqueue_script( 'bootstrap-js', 'URL', '', false, true );
});

// Register Book CPT
function custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Books', 'Book General Name', 'text_domain' ),
		'singular_name'         => _x( 'Book', 'Book Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Books', 'text_domain' ),
		'name_admin_bar'        => __( 'Book', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Book', 'text_domain' ),
		'description'           => __( 'All world books', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'book', $args );

}
add_action( 'init', 'custom_post_type', 0 );