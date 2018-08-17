<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Basis\App\Walker;

class Drawer extends \Walker_Nav_Menu {

	public function __construct() {
		add_filter( 'nav_menu_css_class', [ $this, '_nav_menu_css_class' ], 10, 4 );
	}

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker_Nav_Menu::start_lvl()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = [] ) {
		$output .= '<div class="c-drawer__toggle" aria-expanded="false"><span class="c-ic-angle-right" aria-hidden="true"></span></div><ul class="c-drawer__submenu" aria-hidden="true">';
	}

	/**
	 * Sets up classes
	 *
	 * @return void
	 * @see https://developer.wordpress.org/reference/classes/walker_nav_menu/
	 */
	public function _nav_menu_css_class( $classes, $item, $args, $depth ) {
		if ( ! is_object( $args->walker ) ) {
			return $classes;
		}

		if ( ! $args->walker instanceof \Inc2734\WP_Basis\App\Walker\Drawer ) {
			return $classes;
		}

		if ( $depth > 0 ) {
			$classes[] = 'c-drawer__subitem';
		} else {
			$classes[] = 'c-drawer__item';
		}

		$classes = array_unique( $classes );

		return $classes;
	}
}
