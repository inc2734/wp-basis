<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Basis;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Bootstrap {

	/**
	 * Constructor.
	 */
	public function __construct() {
		load_textdomain( 'inc2734-wp-basis', __DIR__ . '/languages/' . get_locale() . '.mo' );

		$iterator = new RecursiveDirectoryIterator( __DIR__ . '/setup', FilesystemIterator::SKIP_DOTS );
		$iterator = new RecursiveIteratorIterator( $iterator );

		foreach ( $iterator as $file ) {
			if ( ! $file->isFile() ) {
				continue;
			}

			if ( 'php' !== $file->getExtension() ) {
				continue;
			}

			include_once( realpath( $file->getPathname() ) );
		}
	}
}
