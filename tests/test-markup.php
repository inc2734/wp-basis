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

	public function test_oembed_proxy_dimensions_are_independent_of_query_parameter_order() {
		$url     = 'https://example.com/embed';
		$request = new WP_REST_Request( 'GET', '/oembed/1.0/proxy' );
		$iframe  = '<iframe width="100%" height="360"></iframe>';

		foreach ( array( array( 'url' => $url, 'maxwidth' => 640 ), array( 'maxwidth' => 640, 'url' => $url ) ) as $params ) {
			$request->set_query_params( $params );
			$response = apply_filters( 'rest_request_after_callbacks', (object) array( 'html' => $iframe ), array(), $request );
			$this->assertSame( '<iframe width="100000" height="360"></iframe>', $response->html );
		}

		$request->set_route( '/oembed/1.0/embed' );
		$response = apply_filters( 'rest_request_after_callbacks', (object) array( 'html' => $iframe ), array(), $request );
		$this->assertSame( $iframe, $response->html );
	}

	public function test_search_forms_have_unique_labelled_inputs() {
		$ids = array();

		for ( $index = 0; $index < 2; ++$index ) {
			$form = get_search_form( array( 'echo' => false ) );
			$tags = new WP_HTML_Tag_Processor( $form );
			$this->assertStringContainsString( 'c-input-group', $form );
			$this->assertTrue( $tags->next_tag( 'label' ) );
			$field_id = $tags->get_attribute( 'for' );
			$this->assertNotEmpty( $field_id );
			$this->assertTrue( $tags->next_tag( 'input' ) );
			$this->assertSame( 's', $tags->get_attribute( 'name' ) );
			$this->assertSame( $field_id, $tags->get_attribute( 'id' ) );
			$ids[] = $field_id;
		}

		$this->assertNotSame( $ids[0], $ids[1] );
	}

	public function test_drawer_submenu_button_has_an_accessible_name() {
		$walker = new Inc2734\WP_Basis\App\Walker\Drawer();
		$output = '';
		$walker->start_lvl( $output );
		$tags = new WP_HTML_Tag_Processor( $output );

		$this->assertTrue( $tags->next_tag( 'button' ) );
		$this->assertSame( 'Open/close the submenu', $tags->get_attribute( 'aria-label' ) );
		$this->assertSame( 'false', $tags->get_attribute( 'aria-expanded' ) );
		$this->assertTrue( $tags->next_tag( 'span' ) );
		$this->assertSame( 'true', $tags->get_attribute( 'aria-hidden' ) );
	}

	public function test_posts_pagination_preserves_the_labelled_navigation() {
		update_option( 'posts_per_page', 1 );
		self::factory()->post->create_many( 2 );
		$this->go_to( home_url( '/' ) );

		ob_start();
		Inc2734\WP_Basis\App\Model\Pagination::the_posts_pagination();
		$tags = new WP_HTML_Tag_Processor( ob_get_clean() );

		$this->assertTrue( $tags->next_tag( array( 'class_name' => 'c-pagination' ) ) );
		$this->assertTrue( $tags->next_tag( 'nav' ) );
		$this->assertTrue( $tags->has_class( 'pagination' ) );
		$this->assertSame( 'Posts pagination', $tags->get_attribute( 'aria-label' ) );
		$this->assertTrue( $tags->next_tag( array( 'class_name' => 'c-pagination__item' ) ) );
		$this->assertSame( 'page', $tags->get_attribute( 'aria-current' ) );
		$this->assertTrue( $tags->next_tag( array( 'class_name' => 'c-pagination__item-link' ) ) );
		$this->assertNotEmpty( $tags->get_attribute( 'href' ) );
	}

	public function test_password_form_has_a_label_and_post_redirect() {
		$post = self::factory()->post->create_and_get( array( 'post_password' => 'fixture-password' ) );
		$form = get_the_password_form( $post );
		$tags = new WP_HTML_Tag_Processor( $form );

		$this->assertStringContainsString( 'c-input-group', $form );
		$this->assertStringNotContainsString( 'role="alert"', $form );
		$this->assertTrue( $tags->next_tag( 'input' ) );
		$this->assertSame( 'redirect_to', $tags->get_attribute( 'name' ) );
		$this->assertSame( get_permalink( $post ), $tags->get_attribute( 'value' ) );
		$this->assertTrue( $tags->next_tag( 'label' ) );
		$field_id = $tags->get_attribute( 'for' );
		$this->assertNotEmpty( $field_id );
		$this->assertTrue( $tags->next_tag( 'input' ) );
		$this->assertSame( 'post_password', $tags->get_attribute( 'name' ) );
		$this->assertSame( $field_id, $tags->get_attribute( 'id' ) );
	}

	public function test_password_form_displays_the_core_error() {
		$post = self::factory()->post->create_and_get( array( 'post_password' => 'fixture-password' ) );
		$form = apply_filters( 'the_password_form', '', $post, 'Incorrect <strong>password</strong>.' );
		$tags = new WP_HTML_Tag_Processor( $form );

		$this->assertTrue( $tags->next_tag( array( 'class_name' => 'password-form-error' ) ) );
		$this->assertTrue( $tags->next_tag( array( 'class_name' => 'post-password-form-invalid-password' ) ) );
		$this->assertSame( 'alert', $tags->get_attribute( 'role' ) );
		$this->assertTrue( $tags->next_tag( 'p' ) );
		$error_id = $tags->get_attribute( 'id' );
		$this->assertNotEmpty( $error_id );
		$this->assertStringContainsString( 'Incorrect <strong>password</strong>.', $form );
		$this->assertTrue( $tags->next_tag( 'input' ) );
		$this->assertSame( 'post_password', $tags->get_attribute( 'name' ) );
		$this->assertSame( $error_id, $tags->get_attribute( 'aria-describedby' ) );
	}
}
