<?php

use \WPAustin\WPUnitTests;

class Byline_Tests extends WP_UnitTestCase {

	public function test_register() {

		\WPAustin\WPUnitTests\register();

		// Verfify the plugin was loaded and actions/hooks are registered.
		$this->assertEquals( 10, has_action( 'add_meta_boxes', 'WPAustin\WPUnitTests\register_byline_meta_box' ), 'add_meta_boxes not registered' );
		$this->assertEquals( 10, has_action( 'save_post', 'WPAustin\WPUnitTests\save_byline_meta_box' ), 'save_post not registered' );
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
}
