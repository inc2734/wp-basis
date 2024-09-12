<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

add_filter(
	'nav_menu_item_args',
	function( $args ) {
		return is_array( $args )
			? (object) $args
			: $args;
	}
);
