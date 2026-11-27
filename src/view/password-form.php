<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

$field_id = wp_unique_id( 'pwbox-' );
$error_id = 'error-' . $field_id;
?>
<form action="<?php echo esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ); ?>" class="post-password-form<?php echo $has_error ? ' password-form-error' : ''; ?>" method="post">
	<?php if ( $redirect_to ) : ?>
		<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
	<?php endif; ?>
	<?php if ( $has_error ) : ?>
		<div class="post-password-form-invalid-password" role="alert">
			<p id="<?php echo esc_attr( $error_id ); ?>"><?php echo wp_kses_post( $invalid_password ); ?></p>
		</div>
	<?php endif; ?>
	<p>
		<?php esc_html_e( 'This content is password protected. To view it please enter your password below:', 'inc2734-wp-basis' ); ?>
	</p>
	<div class="c-input-group">
		<div class="c-input-group__addon">
			<label for="<?php echo esc_attr( $field_id ); ?>"><?php esc_html_e( 'Password:', 'inc2734-wp-basis' ); ?></label>
		</div>
		<div class="c-input-group__field">
			<input name="post_password" id="<?php echo esc_attr( $field_id ); ?>" type="password" size="20"<?php echo $has_error ? ' aria-describedby="' . esc_attr( $error_id ) . '"' : ''; ?> />
		</div>
		<input class="c-input-group__btn" type="submit" name="Submit" value="<?php esc_attr_e( 'Enter', 'inc2734-wp-basis' ); ?>" />
	</div>
</form>
