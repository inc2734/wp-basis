<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */
?>
<form action="<?php echo esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ); ?>" class="post-password-form" method="post">
	<p>
		<?php
		$message = 'This content is password protected. To view it please enter your password below:';
		echo esc_html( apply_filters( 'inc2734_wp_basis_password_form_message', $message ) );
		?>
	</p>
	<div class="c-input-group">
		<div class="c-input-group__addon">
			<?php
			$label = 'Password:';
			echo esc_html( apply_filters( 'inc2734_wp_basis_password_form_label', $label ) );
			?>
		</div>
		<div class="c-input-group__field">
			<input name="post_password" type="password" size="20" />
		</div>
		<?php $submit_label = 'Enter'; ?>
		<input class="c-input-group__btn" type="submit" name="Submit" value="<?php echo esc_attr( apply_filters( 'inc2734_wp_basis_password_form_submit_label', $submit_label ) ); ?>" />
	</div>
</form>
