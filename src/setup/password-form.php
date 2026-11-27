<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Sets up password form markup
 *
 * @param string       $output           The password form HTML.
 * @param WP_Post|null $post             The protected post.
 * @param string       $invalid_password The invalid password message from WordPress.
 * @return string
 */
add_filter(
	'the_password_form',
	function ( $output, $post = null, $invalid_password = '' ) {
		$redirect_to = ! empty( $post->ID ) ? get_permalink( $post ) : '';
		$has_error   = '' !== $invalid_password;

		ob_start();
		include __DIR__ . '/../view/password-form.php';
		$output = ob_get_clean();
		$output = str_replace( array( "\n", "\r", "\n\r", "\t" ), '', $output );
		return $output;
	},
	10,
	3
);

/**
 * Remove unnecessary tags
 *
 * @param string $content
 * @return string
 */
add_action(
	'the_content',
	function ( $content ) {
		return preg_replace( '/<p>(<input class="c-input-group__btn")/', '$1', $content );
	}
);
