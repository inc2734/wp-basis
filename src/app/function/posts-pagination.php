<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * the_posts_pagination() for Basis
 *
 * @return void
 */
function wpbasis_the_posts_pagination() {
	Inc2734\WP_Basis\App\Model\Pagination::the_posts_pagination();
}
