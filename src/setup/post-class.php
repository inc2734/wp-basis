<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Remove .hentry.
 *
 * @param array $classes An array of post classes.
 * @return array
 */
add_filter(
	'post_class',
	function( $classes ) {
		if ( in_array( 'hentry', $classes, true ) ) {
			unset( $classes[ array_search( 'hentry', $classes, true ) ] );
		}
		return $classes;
	}
);

/**
 * Added ._c-entry.
 *
 * @param array $classes An array of post classes.
 * @return array
 */
add_filter(
	'post_class',
	function( $classes ) {
		if ( ! in_array( 'c-entry', $classes, true ) ) {
			$classes[] = 'c-entry';
		}
		return $classes;
	}
);
