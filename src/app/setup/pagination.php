<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Update pagination for singular post
 *
 * @param string $pagination
 * @return string
 */
add_filter( 'wp_link_pages_link', function( $pagination ) {
	$pagination = preg_replace(
		'/^(\d+)$/',
		'<span class="page-numbers current">$1</span>',
		$pagination
	);
	$pagination = preg_replace(
		'/^<a([^>]+)>(\d+?)<\/a>$/',
		'<a class="page-numbers" $1>$2</a>',
		$pagination
	);
	$pagination = _wpbasis_pagination( $pagination );
	$pagination .= "\n";

	return $pagination;
} );

/**
 * wp_link_pages() for Basis
 *
 * @return void
 */
function wpbasis_the_wp_link_pages() {
	ob_start();

	wp_link_pages( [
		'before'           => '<div class="_c-pagination"><div class="nav-links">',
		'after'            => '</div></div>',
		'link_before'      => '',
		'link_after'       => '',
		'separator'        => '',
		'nextpagelink'     => '&gt;',
		'previouspagelink' => '%lt;',
		'pagelink'         => '%',
	] );

	_wpbasis_sanitize_pagination_e( ob_get_clean() );
}
/**
 * the_posts_pagination() for Basis
 *
 * @return void
 */
function wpbasis_the_posts_pagination() {
	?>
	<div class="_c-pagination">
		<?php
		ob_start();

		the_posts_pagination( [
			'prev_text' => '<i class="fa fa-angle-left" aria-hidden="true"></i>',
			'next_text' => '<i class="fa fa-angle-right" aria-hidden="true"></i>',
		] );

		_wpbasis_sanitize_pagination_e( _wpbasis_pagination( ob_get_clean() ) );
		?>
	</div>
	<?php
}

/**
 * Print sanitized pagination
 *
 * @param string $pagination
 * @return void
 */
function _wpbasis_sanitize_pagination_e( $pagination ) {
	echo wp_kses(
		$pagination,
		[
			'h2' => [
				'class' => [],
			],
			'div' => [
				'class' => [],
			],
			'span' => [
				'class'        => [],
				'aria-current' => [],
				'aria-hidden'  => [],
			],
			'a' => [
				'class' => [],
				'href'  => [],
			],
			'i' => [
				'class'       => [],
				'aria-hidden' => [],
			],
		]
	);
}

/**
 * Update pagination
 *
 * @param string $pagination
 * @return string
 */
function _wpbasis_pagination( $pagination ) {
	$pagination = str_replace(
		"'",
		'"',
		$pagination
	);
	$pagination = str_replace(
		'<span class="page-numbers',
		'<span class="_c-pagination__item',
		$pagination
	);
	$pagination = str_replace(
		'<a class="page-numbers',
		'<a class="_c-pagination__item-link',
		$pagination
	);
	$pagination = str_replace(
		' current"',
		' " aria-current="page"',
		$pagination
	);
	$pagination = str_replace(
		'_c-pagination__item dots"',
		'_c-pagination__item-ellipsis" aria-hidden="true"',
		$pagination
	);
	$pagination = str_replace(
		[ 'next page-numbers', 'prev page-numbers' ],
		'_c-pagination__item-link',
		$pagination
	);

	return $pagination;
}
