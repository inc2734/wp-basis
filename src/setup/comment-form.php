<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Sets up default fields html.
 *
 * @param array $fields The default comment fields.
 * @return array
 */
add_filter(
	'comment_form_default_fields',
	function( $fields ) {
		foreach ( $fields as $key => $field ) {
			$fields[ $key ] = wpbasis_add_class_attribute( $field );
		}
		return $fields;
	}
);

/**
 * Sets up the comment field html.
 *
 * @param string $fields The content of the comment textarea field.
 * @return string
 */
add_filter(
	'comment_form_field_comment',
	function( $comment_field ) {
		return wpbasis_add_class_attribute( $comment_field );
	}
);

/**
 * Sets up submit button.
 *
 * @param string $submit_field HTML markup for the submit field.
 * @return string
 */
add_filter(
	'comment_form_submit_field',
	function( $submit_field ) {
		return str_replace( 'class="submit"', 'class="c-btn"', $submit_field );
	}
);

/**
 * Add class attribute for the field.
 *
 * @param string $field The field html.
 */
function wpbasis_add_class_attribute( $field ) {
	if ( false !== strpos( $field, 'type="checkbox"' ) ) {
		return $field;
	}

	return preg_replace( '/(id=".+?")/', '$1 class="c-form-control"', $field );
}
