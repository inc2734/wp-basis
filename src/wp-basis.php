<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Main class
 */
class Inc2734_WP_Basis {

	public function __construct() {
		$includes = array(
			'/app/setup',
		);
		foreach ( $includes as $include ) {
			foreach ( glob( __DIR__ . $include . '/*.php' ) as $file ) {
				require_once( $file );
			}
		}
	}
}
