<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Basis\App\Model;

class Pagination {

	public static function the_wp_link_pages() {
		ob_start();

		wp_link_pages(
			[
				'before'           => '<div class="c-pagination"><div class="nav-links">',
				'after'            => '</div></div>',
				'link_before'      => '',
				'link_after'       => '',
				'separator'        => '',
				'nextpagelink'     => '&gt;',
				'previouspagelink' => '%lt;',
				'pagelink'         => '%',
			]
		);

		self::_sanitize_pagination_e( ob_get_clean() );
	}

	/**
	 * the_posts_pagination() for Basis
	 *
	 * @return void
	 */
	public static function the_posts_pagination() {
		ob_start();

		the_posts_pagination(
			[
				'prev_text' => '<i class="fa fa-angle-left" aria-hidden="true"></i>',
				'next_text' => '<i class="fa fa-angle-right" aria-hidden="true"></i>',
			]
		);

		$pagination = self::pagination( ob_get_clean() );
		if ( ! $pagination ) {
			return;
		}
		?>
		<div class="c-pagination">
			<?php self::_sanitize_pagination_e( $pagination ); ?>
		</div>
		<?php
	}

	/**
	 * the_comments_pagination() for Basis
	 *
	 * @return void
	 */
	public static function the_comments_pagination( $args = array() ) {
		ob_start();

		$args = array_merge(
			$args,
			[
				'prev_text' => '<i class="fa fa-angle-left" aria-hidden="true"></i>',
				'next_text' => '<i class="fa fa-angle-right" aria-hidden="true"></i>',
			]
		);
		the_comments_pagination( $args );

		$pagination = self::pagination( ob_get_clean() );
		if ( ! $pagination ) {
			return;
		}
		?>
		<div class="c-pagination">
			<?php self::_sanitize_pagination_e( $pagination ); ?>
		</div>
		<?php
	}

	/**
	 * Update pagination
	 *
	 * @param string $pagination
	 * @return string
	 */
	public static function pagination( $pagination ) {
		$pagination = str_replace(
			"'",
			'"',
			$pagination
		);

		$pagination = preg_replace(
			'|<span ([^>]*?)class="page-numbers|',
			'<span $1 class="c-pagination__item',
			$pagination
		);

		$pagination = preg_replace(
			'|<span ([^>]*?)class="post-page-numbers|',
			'<span $1 class="c-pagination__item',
			$pagination
		);

		$pagination = str_replace(
			'<a class="page-numbers',
			'<a class="c-pagination__item-link',
			$pagination
		);

		$pagination = str_replace(
			'c-pagination__item dots"',
			'c-pagination__item-ellipsis" aria-hidden="true"',
			$pagination
		);

		$pagination = str_replace(
			[ 'next page-numbers', 'prev page-numbers' ],
			'c-pagination__item-link',
			$pagination
		);

		$pagination = preg_replace(
			'|<a class="c-pagination__item-link" href="([^"]+?)"><i class="fa fa-angle-right"|',
			'<a class="c-pagination__item-link c-pagination__item-prev c-pagination__item-right" href="$1"><i class="fa fa-angle-right"',
			$pagination
		);

		$pagination = preg_replace(
			'|<a class="c-pagination__item-link" href="([^"]+?)"><i class="fa fa-angle-left"|',
			'<a class="c-pagination__item-link c-pagination__item-next c-pagination__item-left" href="$1"><i class="fa fa-angle-left"',
			$pagination
		);

		return $pagination;
	}

	/**
	 * Print sanitized pagination
	 *
	 * @param string $pagination
	 * @return void
	 */
	protected static function _sanitize_pagination_e( $pagination ) {
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
}
