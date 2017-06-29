<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */
?>
<form role="search" method="get" class="p-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<?php $label = 'Search for:'; ?>
	<label class="screen-reader-text" for="s"><?php echo esc_html( apply_filters( 'inc2734_wp_basis_searchform_label', $label ) ); ?></label>
	<div class="c-input-group">
		<div class="c-input-group__field">
			<?php $placeholder = 'Search &hellip;'; ?>
			<input type="search" placeholder="<?php echo esc_attr( apply_filters( 'inc2734_wp_basis_searchform_placeholder', $placeholder ) ); ?>" value="<?php echo get_search_query(); ?>" name="s">
		</div>
			<?php $submit_label = 'Search'; ?>
		<button class="c-input-group__btn"><?php echo esc_attr( apply_filters( 'inc2734_wp_basis_searchform_submit_label', $submit_label ) ); ?></button>
	</div>
</form>
