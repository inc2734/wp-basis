<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Basis\App\Walker;

class Navbar extends \Walker_Nav_Menu {

	/**
	 * Constructor.
	 *
	 * @param array $args Array of argment.
	 */
	public function __construct( array $args = [] ) {
		$this->args = shortcode_atts(
			[
				'popup-mode' => 'hover',
			],
			$args
		);
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
	public function start_lvl(
		&$output,
		// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		$depth = 0,
		$args = []
		// phpcs:enable
	) {
		if ( 'click' === $this->args['popup-mode'] ) {
			$output .= '<button class="c-navbar__toggle" aria-expanded="false" aria-label="' . __( 'Open/close the submenu', 'inc2734-wp-basis' ) . '">
				<span class="c-ic-angle-right" aria-hidden="true"></span>
			</button>';
		}
		$output .= '<ul class="c-navbar__submenu" aria-hidden="true">';
	}

	/**
	 * Starts the element output.
	 *
	 * @see Walker_Nav_Menu::start_el()
	 *
	 * @param string   $output  Used to append additional content (passed by reference).
	 * @param WP_Post  $item    Menu item data object.
	 * @param int      $depth   Depth of menu item. Used for padding.
	 * @param stdClass $args    An object of wp_nav_menu() arguments.
	 * @param int      $item_id Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = [], $item_id = 0 ) {
		parent::start_el( $output, $item, $depth, $args, $item_id );

		$output = preg_replace(
			'/menu-item-has-children([^>\"]*?)">/ms',
			'menu-item-has-children$1" aria-haspopup="true">',
			$output
		);
	}

	/**
	 * Sets up classes.
	 *
	 * @see https://developer.wordpress.org/reference/classes/walker_nav_menu/
	 *
	 * @param array    $classes Array of the CSS classes that are applied to the menu item's <li> element.
	 * @param WP_Post  $item    The current menu item.
	 * @param stdClass $args    An object of wp_nav_menu() arguments.
	 * @param int      $depth   Depth of menu item. Used for padding.
	 * @return array
	 */
	public function _nav_menu_css_class( $classes, $item, $args, $depth ) {
		if ( ! is_object( $args->walker ) ) {
			return $classes;
		}

		if ( ! $args->walker instanceof \Inc2734\WP_Basis\App\Walker\Navbar ) {
			return $classes;
		}

		if ( $depth > 0 ) {
			$classes[] = 'c-navbar__subitem';
		} else {
			$classes[] = 'c-navbar__item';
		}

		$classes = array_unique( $classes );

		return $classes;
	}
}
