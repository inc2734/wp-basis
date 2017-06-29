<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * oEmbed container customization
 *
 * @param mixed $cache
 * @param string $url
 * @param array $attr
 * @param int $post_id
 */
add_action( 'embed_oembed_html', function( $cache, $url, $attr, $post_id ) {
	if ( preg_match( '/^https?:\/\/www\.youtube\.com/', $url ) ) {
		$cache = '<div class="c-responsive-container-16-9">' . $cache . '</div>';
	}
	return $cache;
}, 10, 4 );

/**
 * If only oEmbed, pure iframes are not responsive,
 * so pure iframes are maked to force all responsive.
 *
 * @param string $content
 * @return string
 */
add_filter( 'the_content', function( $content ) {
	$content = preg_replace(
		'/(<iframe [^>]*?>[^<]*?<\/iframe>)/i',
		'<div class="c-responsive-container-16-9">$1</div>',
		$content
	);

	$content = preg_replace(
		'/<div class="c-responsive-container"><div class="c-responsive-container">(.*?)<\/div><\/div>/',
		'<div class="c-responsive-container-16-9">$1</div>',
		$content
	);

	return $content;
} );
