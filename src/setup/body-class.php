<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Sets up CSS classes for the body
 *
 * @param array $classes An array of body classes
 * @return array
 */
add_filter(
	'body_class',
	function( $classes ) {
		if ( ! in_array( 'l-body', $classes, true ) ) {
			$classes[] = 'l-body';
		}
		return $classes;
	}
);
