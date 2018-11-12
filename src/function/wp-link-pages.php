<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * wp_link_pages() for Basis
 *
 * @return void
 */
function wpbasis_the_wp_link_pages() {
	Inc2734\WP_Basis\App\Model\Pagination::the_wp_link_pages();
}
