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

	if ( ! has_filter( 'the_author', __NAMESPACE__ . '\filter_the_author' ) ) {
		add_filter( 'the_author', __NAMESPACE__ . '\filter_the_author' );
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

/**
 * Save the meta box details.
 *
 * @param  int $post_id The post ID.
 * @return void
 */
function save_byline_meta_box( $post_id ) {

	$data = filter_var_array( $_POST, [
			get_byline_nonce_field() => FILTER_SANITIZE_STRING,
			'wp_austin_byline' => FILTER_SANITIZE_STRING,
		]
	);

	if ( wp_verify_nonce( $data[ get_byline_nonce_field() ], get_byline_meta_key() ) ) {
		if ( ! empty( $data['wp_austin_byline'] ) ) {
			update_post_meta( $post_id, get_byline_meta_key(), $data['wp_austin_byline'] );
		} else {
			delete_post_meta( $post_id, get_byline_meta_key() );
		}
	}
}

/**
 * Filter the author name of the current post to return a byline.
 *
 * @param string $author Default author name.
 * @return string.
 */
function filter_the_author( $author ) {

	$byline = get_byline( get_the_ID() );
	if ( ! empty( $byline ) ) {
		$author = $byline;
	}

	return $author;
}
