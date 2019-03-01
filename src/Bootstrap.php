<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Basis;

class Bootstrap {

	public function __construct() {
		load_textdomain( 'inc2734-wp-basis', __DIR__ . '/languages/' . get_locale() . '.mo' );

		$includes = [
			'/setup',
		];
		foreach ( $includes as $include ) {
			foreach ( glob( __DIR__ . $include . '/*.php' ) as $file ) {
				require_once( $file );
			}
		}
	}
}
