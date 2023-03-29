<?php
/**
 * func files
 */

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