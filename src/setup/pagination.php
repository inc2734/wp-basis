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
add_filter(
	'wp_link_pages_link',
	function( $pagination ) {
		$pagination  = preg_replace(
			'/^(\d+)$/',
			'<span class="page-numbers current">$1</span>',
			$pagination
		);
		$pagination  = preg_replace(
			'/^<a([^>]+)>(\d+?)<\/a>$/',
			'<a class="page-numbers" $1>$2</a>',
			$pagination
		);
		$pagination  = Inc2734\WP_Basis\App\Model\Pagination::pagination( $pagination );
		$pagination .= "\n";

		return $pagination;
	}
);
