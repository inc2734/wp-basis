<?php
/**
 * Markup regression tests.
 *
 * @package inc2734/wp-basis
 */

class MarkupTest extends WP_UnitTestCase {

	public function test_layout_classes_are_preserved() {
		$this->assertContains( 'l-body', get_body_class() );
		$this->assertSame( 1, count( array_keys( apply_filters( 'body_class', array( 'l-body' ) ), 'l-body', true ) ) );
		$classes = get_post_class( '', self::factory()->post->create() );
		$this->assertContains( 'c-entry', $classes );
		$this->assertNotContains( 'hentry', $classes );
	}

	public function test_responsive_embeds_preserve_the_iframe() {
		foreach ( array( array( 640, 360, '16-9' ), array( 640, 480, '4-3' ) ) as $dimensions ) {
			list( $width, $height, $ratio ) = $dimensions;
			$iframe = sprintf( '<iframe src="https://example.com/embed" width="%d" height="%d"></iframe>', $width, $height );
			$this->assertSame(
				'<div class="c-responsive-container-' . $ratio . '">' . $iframe . '</div>',
				apply_filters( 'embed_oembed_html', $iframe, 'https://example.com/embed' )
			);
		}
	}

	public function test_responsive_embeds_can_be_disabled() {
		$iframe = '<iframe src="https://example.com/embed" width="640" height="360"></iframe>';
		add_filter( 'inc2734_wp_basis_use_responsive_iframe', '__return_false' );
		try {
			$this->assertSame( $iframe, apply_filters( 'embed_oembed_html', $iframe, 'https://example.com/embed' ) );
		} finally {
			remove_filter( 'inc2734_wp_basis_use_responsive_iframe', '__return_false' );
		}
	}

	public function test_search_form_uses_basis_markup() {
		$form = get_search_form( array( 'echo' => false ) );
		$this->assertStringContainsString( 'c-input-group', $form );
		$this->assertStringContainsString( 'name="s"', $form );
	}
}
