<?php

namespace WPAustin\WPUnitTests;

/**
 * Register plugin hooks and filters.
 *
 * @return void
 */
function register() {
	if ( ! has_action( 'add_meta_boxes', __NAMESPACE__ . '\register_byline_meta_box' ) ) {
		add_action( 'add_meta_boxes', __NAMESPACE__ . '\register_byline_meta_box' );
	}

	if ( ! has_action( 'save_post', __NAMESPACE__ . '\save_byline_meta_box' ) ) {
		add_action( 'save_post', __NAMESPACE__ . '\save_byline_meta_box' );
	}
}

/**
 * Returns the meta key used for storing bylines
 *
 * @return string
 */
function get_byline_meta_key() {
	return 'wp_austin_byline';
}

/**
 * Returns the form nonce field name for the meta box.
 *
 * @return string
 */
function get_byline_nonce_field() {
	return 'wp_austin_byline_nonce';
}

/**
 * Registers the meta box.
 *
 * @return void
 */
function register_byline_meta_box() {
	add_meta_box(
		'wp_austin_byline',
		'Custom Byline',
		__NAMESPACE__ . '\display_byline_meta_box',
		'post'
	);
}

/**
 * Gets the byline for a post.
 *
 * @param  int|WP_Post $post The post ID or object.
 * @return string
 */
function get_byline( $post ) {
	$post = get_post( $post );
	if ( is_a( $post, 'WP_Post' ) ) {
		return get_post_meta( $post->ID, get_byline_meta_key(), true );
	} else {
		return false;
	}
}

/**
 * Displays the meta box for bylines.
 *
 * @param  WP_Post $post The post object.
 * @return void
 */
function display_byline_meta_box( $post ) {

	wp_nonce_field( get_byline_meta_key(), get_byline_nonce_field() );

	$byline = get_byline( $post );

	?>
		<input type="text" class="regular-text" name="wp_austin_byline" value="<?php echo esc_attr( $byline ); ?>" placeholder="Enter a custom byline to replace author" />
	<?php
}

function save_byline_meta_box() {
	// TODO
}

function filter_post_author() {
	// TODO
}
