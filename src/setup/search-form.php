<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Sets up search form markup
 *
 * @param string $output
 * @return string
 */
add_filter(
	'get_search_form',
	function( $output ) {
		ob_start();
		include( __DIR__ . '/../view/searchform.php' );
		$output = ob_get_clean();
		$output = str_replace( [ "\n", "\r", "\n\r", "\t" ], '', $output );
		return $output;
	}
);
