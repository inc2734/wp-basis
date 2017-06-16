# WP Basis

[![Build Status](https://travis-ci.org/inc2734/wp-basis.svg?branch=master)](https://travis-ci.org/inc2734/wp-basis)
[![Latest Stable Version](https://poser.pugx.org/inc2734/wp-basis/v/stable)](https://packagist.org/packages/inc2734/wp-basis)
[![License](https://poser.pugx.org/inc2734/wp-basis/license)](https://packagist.org/packages/inc2734/wp-basis)

## Install
```
$ composer require inc2734/wp-basis
```

## How to use
```
<?php
// When Using composer auto loader
// $Basis = new Inc2734\WP_Basis\Basis();

// When not Using composer auto loader
include_once( get_template_directory() . '/vendor/inc2734/wp-basis/src/wp-basis.php' );
$Basis = new Inc2734_WP_Basis();
```

### Install sass-basis
You need to install sass-basis on your theme by yourself.
https://sass-basis.github.io/getstarted.html
