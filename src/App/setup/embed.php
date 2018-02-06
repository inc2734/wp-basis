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
	if ( wp_basis_is_16to9_oembed_domains( $url ) ) {
		$cache = '<div class="c-responsive-container-16-9">' . $cache . '</div>';
	} elseif ( wp_basis_is_4to3_oembed_domains( $url ) ) {
		$cache = '<div class="c-responsive-container-4-3">' . $cache . '</div>';
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
	if ( ! apply_filters( 'inc2734_wp_basis_use_responsive_iframe', true ) ) {
		return $content;
	}

	preg_match(
		'/<iframe[^>]*?src=["\']?([^"\'> ]*)["\']?[^<]*?<\/iframe>/i',
		$content,
		$reg
	);

	if ( ! empty( $reg[1] ) ) {
		if ( wp_basis_is_oembed_domains( $reg[1] ) ) {
			$content = preg_replace(
				'/(<iframe [^>]*?>[^<]*?<\/iframe>)/i',
				'<div class="c-responsive-container-16-9">$1</div>',
				$content
			);
		}
	}

	$content = preg_replace(
		'/<div class="c-responsive-container-([^ \"]+?)"><div class="c-responsive-container-[^ \"]+?">(.*?)<\/div><\/div>/',
		'<div class="c-responsive-container-$1">$2</div>',
		$content
	);

	return $content;
} );

/**
 * Return true when oEmbed URL
 *
 * @param string $src
 * @return boolean
 */
function wp_basis_is_oembed_domains( $src ) {
	$patterns = array_merge(
		wp_basis_get_16to9_oembed_domains(),
		wp_basis_get_4to3_oembed_domains()
	);

	foreach ( $patterns as $pattern ) {
		if ( preg_match( '/^' . $pattern . '/', $src ) ) {
			return true;
		}
	}
	return false;
}

/**
 * Return 16:9 oembed domains
 *
 * @return array
 */
function wp_basis_get_16to9_oembed_domains() {
	return [
		'(https?:)?\/\/www\.youtube\.com',
		'(https?:)?\/\/youtu.be',
		'(https?:)?\/\/vimeo.com',
	];
}

/**
 * Return true when 16:9 oEmbed URL
 *
 * @param string $url
 * @return boolean
 */
function wp_basis_is_16to9_oembed_domains( $url ) {
	$patterns = wp_basis_get_16to9_oembed_domains();
	foreach ( $patterns as $pattern ) {
		if ( preg_match( '/^' . $pattern . '/', $url ) ) {
			return true;
		}
	}
	return false;
}

/**
 * Return 4:3 oembed domains
 *
 * @return array
 */
function wp_basis_get_4to3_oembed_domains() {
	return [
		'(https?:)?\/\/www\.slideshare\.net',
		'(https?:)?\/\/speakerdeck\.com',
	];
}

/**
 * Return true when 4:3 oEmbed URL
 *
 * @param string $url
 * @return boolean
 */
function wp_basis_is_4to3_oembed_domains( $url ) {
	$patterns = wp_basis_get_4to3_oembed_domains();
	$patterns = apply_filters( 'inc2734_wp_basis_4to3_oembed_domains', $patterns );
	foreach ( $patterns as $pattern ) {
		if ( preg_match( '/^' . $pattern . '/', $url ) ) {
			return true;
		}
	}
	return false;
}
