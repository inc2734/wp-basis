<?php
/**
 * Class SampleTest
 *
 * @package inc2734/wp-basis
 */

/**
 * @todo
 */
class SampleTest extends WP_UnitTestCase {

	public function set_up() {
		parent::set_up();
	}

	public function tear_down() {
		parent::tear_down();
	}

	public function test_sample() {
		$bootstrap  = new Inc2734\WP_Basis\Bootstrap();
		$pagination = new Inc2734\WP_Basis\App\Model\Pagination();

		$this->assertTrue( is_a( $bootstrap, 'Inc2734\WP_Basis\Bootstrap' ) );
		$this->assertTrue( is_a( $pagination, 'Inc2734\WP_Basis\App\Model\Pagination' ) );
	}
}
