<?php

use \WPAustin\WPUnitTests;

class Byline_Tests extends WP_UnitTestCase {

	public function test_register() {

		\WPAustin\WPUnitTests\register();

		// Verfify the plugin was loaded and actions/hooks are registered.
		$this->assertEquals( 10, has_action( 'add_meta_boxes', 'WPAustin\WPUnitTests\register_byline_meta_box' ), 'add_meta_boxes not registered' );
		$this->assertEquals( 10, has_action( 'save_post', 'WPAustin\WPUnitTests\save_byline_meta_box' ), 'save_post not registered' );
		$this->assertEquals( 10, has_filter( 'the_author', 'WPAustin\WPUnitTests\filter_the_author' ), 'filter_the_author not registered' );
	}

	public function test_get_keys() {
		$this->assertEquals( 'wp_austin_byline', WPUnitTests\get_byline_meta_key() );
		$this->assertEquals( 'wp_austin_byline_nonce', WPUnitTests\get_byline_nonce_field() );
	}

	public function test_register_meta_boxes() {

		global $wp_meta_boxes;

		\WPAustin\WPUnitTests\register();

		// Create a post.
		$post_id = wp_insert_post( [
				'post_type' => 'post',
				'post_status' => 'auto-draft',
				'post_title' => 'test_register_meta_boxes',
			], true
		);

		// Verify the post was created,
		$this->assertGreaterThan( 0, $post_id );

		// Call the action that our plugin uses to register meta boxes.
		do_action( 'add_meta_boxes', get_post_type( $post_id ), get_post( $post_id ) );

		// Verify the box was registered for 'post' post type.
		$this->assertNotEmpty( $wp_meta_boxes );
		$this->assertNotEmpty( $wp_meta_boxes['post'] );
		$this->assertNotEmpty( $wp_meta_boxes['post']['advanced'] );
		$this->assertNotEmpty( $wp_meta_boxes['post']['advanced']['default'] );
		$this->assertNotEmpty( $wp_meta_boxes['post']['advanced']['default']['wp_austin_byline'] );
		$this->assertEquals( 'WPAustin\WPUnitTests\display_byline_meta_box', $wp_meta_boxes['post']['advanced']['default']['wp_austin_byline']['callback'] );
	}

	public function test_display_byline_meta_box() {

		\WPAustin\WPUnitTests\register();

		// Create a post.
		$post_id = wp_insert_post( [
				'post_type' => 'post',
				'post_status' => 'auto-draft',
				'post_title' => 'test_do_meta_boxes',
			], true
		);

		// Verify the post was created,
		$this->assertGreaterThan( 0, $post_id );

		$post = get_post( $post_id );

		// Now render the registered meta boxes.
		ob_start();
		\WPAustin\WPUnitTests\display_byline_meta_box( $post );
		$html = ob_get_clean();

		// Verify we have a nonce.
		$nonce = wp_create_nonce( \WPAustin\WPUnitTests\get_byline_meta_key() );
		$this->assertContains( 'value="' . $nonce . '"', $html );

		// What else should we test?

		// Live coding here.
	}

	public function test_get_byline() {

		// Create a post.
		$post_id = wp_insert_post( [
				'post_type' => 'post',
				'post_status' => 'auto-draft',
				'post_title' => 'test_get_byline',
			], true
		);

		// Verify the post was created,
		$this->assertGreaterThan( 0, $post_id );

		// Verify there is no byline with an invalid post.
		$byline = \WPAustin\WPUnitTests\get_byline( 999999 );
		$this->assertEmpty( $byline );

		// Verify there is no byline.
		$byline = \WPAustin\WPUnitTests\get_byline( $post_id );
		$this->assertEmpty( $byline );

		// Set a byline and verify it's there.
		update_post_meta( $post_id, \WPAustin\WPUnitTests\get_byline_meta_key(), 'test_get_byline' );
		$byline = \WPAustin\WPUnitTests\get_byline( $post_id );
		$this->assertEquals( 'test_get_byline', $byline );
	}

	public function test_full_meta_box() {

		\WPAustin\WPUnitTests\register();

		// Create a post.
		$post_id = wp_insert_post( [
				'post_type' => 'post',
				'post_status' => 'auto-draft',
				'post_title' => 'test_full_meta_box',
			], true
		);

		// Verify the post was created,
		$this->assertGreaterThan( 0, $post_id );
		
		// Setup the POST variables that the form would be submitting.
		$_POST = [
			\WPAustin\WPUnitTests\get_byline_nonce_field() => wp_create_nonce( \WPAustin\WPUnitTests\get_byline_meta_key() ),
			'wp_austin_byline' => 'Clyde Nelson, The Best Boxer Dog Ever',
		];

		// Save the meta box.
		\WPAustin\WPUnitTests\save_byline_meta_box( $post_id );

		// Render the meta box.
		ob_start();
		\WPAustin\WPUnitTests\display_byline_meta_box( get_post( $post_id ) );
		$html = ob_get_clean();

		// Verify the the author name is in the input field.
		$this->assertContains( 'value="Clyde Nelson, The Best Boxer Dog Ever"', $html );

		// What about the author name?
		global $post;
		$post = get_post( $post_id );
		setup_postdata( $post );

		$author_name = get_the_author();

		$this->assertEquals( 'Clyde Nelson, The Best Boxer Dog Ever', $author_name );
	}
}
