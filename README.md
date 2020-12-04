# WP Basis

![CI](https://github.com/inc2734/wp-basis/workflows/CI/badge.svg)
[![Latest Stable Version](https://poser.pugx.org/inc2734/wp-basis/v/stable)](https://packagist.org/packages/inc2734/wp-basis)
[![License](https://poser.pugx.org/inc2734/wp-basis/license)](https://packagist.org/packages/inc2734/wp-basis)

## Requirements
* Node.js

## Install
```
$ composer require inc2734/wp-basis
```

## How to use
```
<?php
// When Using composer auto loader
$Basis = new Inc2734\WP_Basis\Bootstrap();
```

```
// in style.scss
$_font-path: '/PATH/TO/vendor/inc2734/wp-basis/src/assets/packages/sass-basis/src/font' !default;
@import '/PATH/TO/vendor/inc2734/wp-basis/src/assets/packages/sass-basis/src/css/basis';
```

```
// in js
import '/PATH/TO/vendor/inc2734/wp-basis/src/assets/packages/sass-basis/src/js/basis.js';

import BasisStickyHeader from '/PATH/TO/vendor/inc2734/wp-basis/src/assets/packages/sass-basis-layout/src/js/sticky-header.js';
document.addEventListener(
  'DOMContentLoaded',
  () => {
    new BasisStickyHeader();
  },
  false
);
```

## Walker_Nav_Menu for navbar
```
wp_nav_menu( [
  'walker' => new \Inc2734\WP_Basis\App\Walker\Navbar(),
] );
```

## Walker_Nav_Menu for drawer
```
wp_nav_menu( [
  'walker' => new \Inc2734\WP_Basis\App\Walker\Drawer(),
] );
```

## Filter hooks
### inc2734_wp_basis_use_responsive_iframe
```
/**
 * Return false when you don't want to use responsive iframe
 *
 * @param boolean $use true
 * @return boolean
 */
add_filter(
  'inc2734_wp_basis_use_responsive_iframe',
  function( $use ) {
    return false;
  }
);
```

### inc2734_wp_basis_4to3_oembed_domains
```
/**
 * oEmbed container size is 16 to 9.
 * Return domains if you want to make the size 4 to 3 in some domains.
 *
 * @param array $domains
 *    @var string https?:\/\/www\.slideshare\.net
 *    @var string https?:\/\/speakerdeck\.com
 * @return array
 */
add_filter(
  'inc2734_wp_basis_4to3_oembed_domains',
  function( $domains ) {
    return $domains;
  }
);
```

### inc2734_wp_basis_wp_link_pages_args
```
/**
 * @see https://developer.wordpress.org/reference/functions/wp_link_pages/
 * @param array $args
 * @return array
 */
add_filter(
  'inc2734_wp_basis_wp_link_pages_args',
  function( $args ) {
    return $args;
  }
);
```

### inc2734_wp_basis_posts_pagination_args
```
/**
 * @see https://developer.wordpress.org/reference/functions/get_the_posts_pagination/
 * @param array $args
 * @return array
 */
add_filter(
  'inc2734_wp_basis_posts_pagination_args',
  function( $args ) {
    return $args;
  }
);
```

### inc2734_wp_basis_comments_pagination_args
```
/**
 * @see https://developer.wordpress.org/reference/functions/get_the_comments_pagination/
 * @param array $args
 * @return array
 */
add_filter(
  'inc2734_wp_basis_comments_pagination_args',
  function( $args ) {
    return $args;
  }
);
```
