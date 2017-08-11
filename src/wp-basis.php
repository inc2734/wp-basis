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
		load_textdomain( 'inc2734-wp-basis', __DIR__ . '/languages/' . get_locale() . '.mo' );

		$includes = array(
			'/app/model',
			'/app/setup',
			'/app/function',
		);
		foreach ( $includes as $include ) {
			foreach ( glob( __DIR__ . $include . '/*.php' ) as $file ) {
				require_once( $file );
			}
		}
	}
}
