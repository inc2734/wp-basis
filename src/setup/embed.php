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

		$has_width_and_height = preg_match( '| width=["\']?(\d+)["\']?|', $iframe, $width )
													&& preg_match( '| height=["\']?(\d+)["\']?|', $iframe, $height );

		if ( $has_width_and_height ) {
			$width  = $width[1];
			$height = $height[1];
			$is_px  = false === strpos( $width, '%' ) && false === strpos( $height, '%' );

			if ( $is_px ) {
				$aspect_ratio = $height / $width;
				if ( 0.55 < $aspect_ratio && 0.57 > $aspect_ratio ) {
					$cache = $iframe_before . '<div class="c-responsive-container-16-9">' . $iframe . '</div>' . $iframe_after;
				} elseif ( 0.74 < $aspect_ratio && 0.76 > $aspect_ratio ) {
					$cache = $iframe_before . '<div class="c-responsive-container-4-3">' . $iframe . '</div>' . $iframe_after;
				}
			}
		}

		if ( wp_basis_is_16to9_oembed_domains( $url ) ) {
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
 * Make sure oEmbed REST Requests apply the WP Embed security mechanism for WordPress embeds.
 *
 * @see  https://core.trac.wordpress.org/ticket/32522
 * @see  https://github.com/WordPress/gutenberg/blob/master/lib/rest-api.php
 * @copyright  https://github.com/WordPress/gutenberg
 *
 * @param  WP_HTTP_Response|WP_Error $response The REST Request response.
 * @param  WP_REST_Server            $handler  ResponseHandler instance (usually WP_REST_Server).
 * @param  WP_REST_Request           $request  Request used to generate the response.
 * @return WP_HTTP_Response|object|WP_Error    The REST Request response.
 */
add_action(
	'init',
	function() {
		if ( wp_basis_is_block_embed_rendering_request() ) {
			add_filter(
				'rest_request_after_callbacks',
				function( $response, $handler, $request ) {
					if ( '/oembed/1.0/proxy' !== $request->get_route() ) {
						return $response;
					}

					if ( empty( $_GET['url'] ) ) {
						return $response;
					}

					if ( isset( $response->html ) ) {
						$has_percent_width  = preg_match( '|^<iframe[^>]+ width="\d+%"|ms', $response->html );
						$has_percent_height = preg_match( '|^<iframe[^>]+ height="\d+%"|ms', $response->html );
						if ( ! $has_percent_width && ! $has_percent_height || $has_percent_width && $has_percent_height ) {
							return $response;
						}
					}

					if ( $has_percent_width ) {
						// Set dummy width
						$response->html = str_replace( 'width="100%"', 'width="100000"', $response->html );
					}

					if ( $has_percent_height ) {
						// Set dummy height
						$response->html = str_replace( 'height="100%"', 'height="100000"', $response->html );
					}

					return $response;
				},
				10,
				3
			);
		}
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

/**
 * Return true when block embed rendering request.
 *
 * @return boolean
 */
function wp_basis_is_block_embed_rendering_request() {
	if ( ! isset( $_SERVER['REQUEST_URI'] ) ) {
		return false;
	}

	return false !== strpos( $_SERVER['REQUEST_URI'], '/wp-json/oembed/1.0/proxy?url=' )
			|| false !== strpos( $_SERVER['REQUEST_URI'], urlencode( '/oembed/1.0/proxy' ) );
}
