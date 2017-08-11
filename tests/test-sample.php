<?php
class Sample_Test extends WP_UnitTestCase {

	public function setup() {
		parent::setup();
	}

	public function tearDown() {
		parent::tearDown();
	}

	public function test_sample() {
		new Inc2734\WP_Basis\Basis();
		new Inc2734\WP_Basis\App\Model\Drawer_Nav( 'drawer-nav' );
		new Inc2734\WP_Basis\App\Model\Global_Nav( 'global-nav' );
		new Inc2734\WP_Basis\App\Model\Pagination();
	}
}
