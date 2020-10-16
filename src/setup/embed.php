<?php
/**
 * @package inc2734/wp-basis
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * oEmbed container customization.
 *
 * @param string|false $cache The cached HTML result, stored in post meta.
 * @param string       $url   The attempted embed URL.
 */
add_filter(
	'embed_oembed_html',
	function( $cache, $url ) {
		if ( ! wp_basis_use_responsive_iframe() ) {
			return $cache;
		}

		if ( ! preg_match( '|^(.*?)(<iframe [^>]*?>[\s]*?</iframe>)(.*?)$|ms', $cache, $reg ) ) {
			return $cache;
		}

		$iframe_before = $reg[1];
		$iframe        = $reg[2];
		$iframe_after  = $reg[3];

		if ( preg_match( '| width=["\']?(\d+)["\']?|', $iframe, $width ) && preg_match( '| height=["\']?(\d+)["\']?|', $iframe, $height ) ) {
			$width        = $width[1];
			$height       = $height[1];
			$aspect_ratio = $height / $width;
			if ( 0.55 < $aspect_ratio && 0.57 > $aspect_ratio ) {
				$cache = $iframe_before . '<div class="c-responsive-container-16-9">' . $iframe . '</div>' . $iframe_after;
			} else {
				$cache = $iframe_before . '<div class="c-responsive-container-4-3">' . $iframe . '</div>' . $iframe_after;
			}
		} elseif ( wp_basis_is_16to9_oembed_domains( $url ) ) {
			$cache = $iframe_before . '<div class="c-responsive-container-16-9">' . $iframe . '</div>' . $iframe_after;
		} elseif ( wp_basis_is_4to3_oembed_domains( $url ) ) {
			$cache = $iframe_before . '<div class="c-responsive-container-4-3">' . $iframe . '</div>' . $iframe_after;
		}

		return $cache;
	},
	10,
	2
);

/**
 * Responsive iframe for block editor.
 *
 * @param string|false $cache The cached HTML result, stored in post meta.
 */
add_filter(
	'embed_oembed_html',
	function( $cache ) {
		global $wp_query;

		if ( ! wp_basis_use_responsive_iframe() ) {
			return $cache;
		}

		if ( ! is_object( $wp_query ) || ! is_null( $wp_query->query ) || empty( $_GET['url'] ) ) {
			return $cache;
		}

		// @codingStandardsIgnoreStart
		$cache .= sprintf(
			'<link rel="stylesheet" href="%1$s">',
			esc_url_raw( get_template_directory_uri() . '/vendor/inc2734/wp-basis/src/assets/css/gutenberg-embed.min.css' )
		);
		// @codingStandardsIgnoreEnd

		return $cache;
	}
);

/**
 * Return true when using responsive iframe method.
 *
 * @return boolean
 */
function wp_basis_use_responsive_iframe() {
	return apply_filters( 'inc2734_wp_basis_use_responsive_iframe', true );
}

/**
 * Return true when oEmbed URL.
 *
 * @param string $src Target src.
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
 * Return 16:9 oembed domains.
 *
 * @return array
 */
function wp_basis_get_16to9_oembed_domains() {
	return [
		'(https?:)?\/\/www\.youtube\.com',
		'(https?:)?\/\/youtu.be',
		'(https?:)?\/\/vimeo.com',
		'(https?:)?\/\/speakerdeck\.com',
		'\/\/speakerdeck\.com',
	];
}

/**
 * Return true when 16:9 oEmbed URL.
 *
 * @param string $url Target URL.
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
 * Return 4:3 oembed domains.
 *
 * @return array
 */
function wp_basis_get_4to3_oembed_domains() {
	return [
		'(https?:)?\/\/www\.slideshare\.net',
	];
}

/**
 * Return true when 4:3 oEmbed URL.
 *
 * @param string $url Target URL.
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
