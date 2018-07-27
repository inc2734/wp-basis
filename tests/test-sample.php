<?php
/**
 * @todo
 */
class Sample_Test extends WP_UnitTestCase {

	public function setup() {
		parent::setup();
	}

	public function tearDown() {
		parent::tearDown();
	}

	public function test_sample() {
		new Inc2734\WP_Basis\Basis();
		new Inc2734\WP_Basis\App\Model\Pagination();
	}
}
