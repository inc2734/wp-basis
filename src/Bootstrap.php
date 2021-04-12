<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Basis;

class Bootstrap {

	/**
	 * Constructor.
	 */
	public function __construct() {
		load_textdomain( 'inc2734-wp-basis', __DIR__ . '/languages/' . get_locale() . '.mo' );

		include_once( __DIR__ . '/setup/body-class.php' );
		include_once( __DIR__ . '/setup/comment-form.php' );
		include_once( __DIR__ . '/setup/embed.php' );
		include_once( __DIR__ . '/setup/pagination.php' );
		include_once( __DIR__ . '/setup/password-form.php' );
		include_once( __DIR__ . '/setup/post-class.php' );
		include_once( __DIR__ . '/setup/search-form.php' );
		include_once( __DIR__ . '/setup/tinymce.php' );
	}
}
