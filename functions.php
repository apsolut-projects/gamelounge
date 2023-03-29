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