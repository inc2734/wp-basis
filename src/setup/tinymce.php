<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Sets up the TinyMCE body classes
 *
 * @param array $init An array with TinyMCE config
 * @return array
 */
add_filter(
	'tiny_mce_before_init',
	function( $init ) {
		$init['body_class'] = 'p-entry-content';
		return $init;
	}
);
