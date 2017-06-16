<?php
class Sample_Test extends WP_UnitTestCase {

	public function setup() {
		parent::setup();
		include_once( __DIR__ . '/../src/wp-basis.php' );
	}

	public function tearDown() {
		parent::tearDown();
	}

	public function test_sample() {
		$this->assertTrue( true );
	}
}
