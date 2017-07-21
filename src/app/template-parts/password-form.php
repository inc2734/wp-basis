<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */
?>
<form action="<?php echo esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ); ?>" class="post-password-form" method="post">
	<p>
		<?php esc_html_e( 'This content is password protected. To view it please enter your password below:', 'inc2734-wp-basis' ); ?>
	</p>
	<div class="c-input-group">
		<div class="c-input-group__addon">
			<?php esc_html_e( 'Password:', 'inc2734-wp-basis' ); ?>
		</div>
		<div class="c-input-group__field">
			<input name="post_password" type="password" size="20" />
		</div>
		<input class="c-input-group__btn" type="submit" name="Submit" value="<?php esc_attr_e( 'Enter', 'inc2734-wp-basis' ); ?>" />
	</div>
</form>
