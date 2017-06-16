<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Basis;

/**
 * Main class
 */
class Basis {

	public function __construct() {
		include_once( __DIR__ . '/wp-basis.php' );
		new \Inc2734_WP_Basis();
	}
}
