<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Sets up password form markup
 *
 * @param string $output
 * @return string
 */
add_filter(
	'the_password_form',
	function( $output ) {
		ob_start();
		include( __DIR__ . '/../view/password-form.php' );
		$output = ob_get_clean();
		$output = str_replace( [ "\n", "\r", "\n\r", "\t" ], '', $output );
		return $output;
	}
);

/**
 * Remove unnecessary tags
 *
 * @param string $content
 * @return string
 */
add_action(
	'the_content',
	function( $content ) {
		return preg_replace( '/<p>(<input class="c-input-group__btn")/', '$1', $content );
	}
);
