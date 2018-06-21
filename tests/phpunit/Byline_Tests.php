<?php

class Byline_Tests extends WP_UnitTestCase {

	public function test_register() {
		// Verfify the plugin was loaded and actions/hooks are registered.
		$this->assertEquals( 10, has_action( 'add_meta_boxes', 'WPAustin\WPUnitTests\register_byline_meta_box' ), 'add_meta_boxes not registered' );
		$this->assertEquals( 10, has_action( 'save_post', 'WPAustin\WPUnitTests\save_byline_meta_box' ), 'save_post not registered' );
	}

}
