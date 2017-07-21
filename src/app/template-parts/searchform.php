<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */
?>
<form role="search" method="get" class="p-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="s"><?php esc_html_e( 'Search for:', 'inc2734-wp-basis' ); ?></label>
	<div class="c-input-group">
		<div class="c-input-group__field">
			<input type="search" placeholder="<?php esc_attr_e( 'Search &hellip;', 'inc2734-wp-basis' ); ?>" value="<?php echo get_search_query(); ?>" name="s">
		</div>
			<?php $submit_label = 'Search'; ?>
		<button class="c-input-group__btn"><?php esc_html_e( 'Search', 'inc2734-wp-basis' ); ?></button>
	</div>
</form>
