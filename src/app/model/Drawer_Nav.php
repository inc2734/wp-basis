<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Basis\App\Model;

class Drawer_Nav {

	/**
	 * @var string
	 */
	protected $theme_location;

	public function __construct( $theme_location ) {
		$this->theme_location = $theme_location;

		add_filter( 'wp_nav_menu', [ $this, '_wp_nav_menu' ], 10, 2 );
		add_filter( 'nav_menu_css_class', [ $this, '_nav_menu_css_class' ], 10, 4 );
	}

	/**
	 * Sets up attributes
	 *
	 * @return void
	 * @see https://developer.wordpress.org/reference/functions/wp_nav_menu/
	 */
	public function _wp_nav_menu( $nav_menu, $args ) {
		if ( $args->theme_location !== $this->theme_location ) {
			return $nav_menu;
		}

		return preg_replace(
			'/<ul +class="sub-menu">/ms',
			'<div class="c-drawer__toggle" aria-expanded="false"><span class="c-ic-angle-right" aria-hidden="true"></span></div><ul class="c-drawer__submenu" aria-hidden="true">',
			$nav_menu
		);
	}

	/**
	 * Sets up classes
	 *
	 * @return void
	 * @see https://developer.wordpress.org/reference/classes/walker_nav_menu/
	 */
	public function _nav_menu_css_class( $classes, $item, $args, $depth ) {
		if ( $args->theme_location !== $this->theme_location ) {
			return $classes;
		}

		if ( $depth > 0 ) {
			$classes[] = 'c-drawer__subitem';
		} else {
			$classes[] = 'c-drawer__item';
		}
		return $classes;
	}
}
