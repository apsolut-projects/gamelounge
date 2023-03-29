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
function gl_custom_post_type() {

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
add_action( 'init', 'gl_custom_post_type', 0 );

// tagline metabox
// get_post_meta( get_the_ID(), 'gl_taglinetagline', true )
class Game_Lounge_Tagline {
	private $config = '{"title":"Your Tagline","prefix":"gl_tagline","domain":"gamelounge","class_name":"Game_Lounge_Tagline","post-type":["post"],"context":"normal","priority":"default","cpt":"book","fields":[{"type":"textarea","label":"Tagline","rows":"3","id":"gl_taglinetagline"}]}';

	public function __construct() {
		$this->config = json_decode( $this->config, true );
		$this->process_cpts();
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
		add_action( 'save_post', [ $this, 'save_post' ] );
	}

	public function process_cpts() {
		if ( !empty( $this->config['cpt'] ) ) {
			if ( empty( $this->config['post-type'] ) ) {
				$this->config['post-type'] = [];
			}
			$parts = explode( ',', $this->config['cpt'] );
			$parts = array_map( 'trim', $parts );
			$this->config['post-type'] = array_merge( $this->config['post-type'], $parts );
		}
	}

	public function add_meta_boxes() {
		foreach ( $this->config['post-type'] as $screen ) {
			add_meta_box(
				sanitize_title( $this->config['title'] ),
				$this->config['title'],
				[ $this, 'add_meta_box_callback' ],
				$screen,
				$this->config['context'],
				$this->config['priority']
			);
		}
	}

	public function save_post( $post_id ) {
		foreach ( $this->config['fields'] as $field ) {
			switch ( $field['type'] ) {
				default:
					if ( isset( $_POST[ $field['id'] ] ) ) {
						$sanitized = sanitize_text_field( $_POST[ $field['id'] ] );
						update_post_meta( $post_id, $field['id'], $sanitized );
					}
			}
		}
	}

	public function add_meta_box_callback() {
		$this->fields_table();
	}

	private function fields_table() {
		?><table class="form-table" role="presentation">
		<tbody><?php
		foreach ( $this->config['fields'] as $field ) {
			?><tr>
			<th scope="row"><?php $this->label( $field ); ?></th>
			<td><?php $this->field( $field ); ?></td>
			</tr><?php
		}
		?></tbody>
		</table><?php
	}

	private function label( $field ) {
		switch ( $field['type'] ) {
			default:
				printf(
					'<label class="" for="%s">%s</label>',
					$field['id'], $field['label']
				);
		}
	}

	private function field( $field ) {
		switch ( $field['type'] ) {
			case 'textarea':
				$this->textarea( $field );
				break;
			default:
				$this->input( $field );
		}
	}

	private function input( $field ) {
		printf(
			'<input class="regular-text %s" id="%s" name="%s" %s type="%s" value="%s">',
			isset( $field['class'] ) ? $field['class'] : '',
			$field['id'], $field['id'],
			isset( $field['pattern'] ) ? "pattern='{$field['pattern']}'" : '',
			$field['type'],
			$this->value( $field )
		);
	}

	private function textarea( $field ) {
		printf(
			'<textarea class="regular-text" id="%s" name="%s" rows="%d">%s</textarea>',
			$field['id'], $field['id'],
			isset( $field['rows'] ) ? $field['rows'] : 5,
			$this->value( $field )
		);
	}

	private function value( $field ) {
		global $post;
		if ( metadata_exists( 'post', $post->ID, $field['id'] ) ) {
			$value = get_post_meta( $post->ID, $field['id'], true );
		} else if ( isset( $field['default'] ) ) {
			$value = $field['default'];
		} else {
			return '';
		}
		return str_replace( '\u0027', "'", $value );
	}

}
new Game_Lounge_Tagline;

// document title filter
// get tagline instead of default title
function gamelounge_wp_title( $title ) {
	if ( is_feed() ) {
		return $title;
	}

	// Add the blog description for the home/front page.
	$site_description = get_post_meta( get_the_ID(), 'gl_taglinetagline', true );
	if ( $site_description && 'book' == get_post_type() && (!is_404()) ) {
		$title = $site_description;
	}

	// Add the blog name - usable in some cases
	// $title .= get_bloginfo( 'name', 'display' );


	return $title;
}
add_filter( 'pre_get_document_title', 'gamelounge_wp_title', 10, 2 );