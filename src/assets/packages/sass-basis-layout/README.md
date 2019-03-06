# sass-basis-layout
This is a css module for the Basis.

## repository
* https://github.com/sass-basis/layout/

## Basis
* Repository: https://github.com/sass-basis/basis/
* Documents : https://sass-basis.github.io/

## Get Started
### Install
```
$ npm install --save sass-basis
$ npm install --save sass-basis-layout
```

### Sass
```
@import 'node_modules/sass-basis-layout/src/css/basis';
@import 'node_modules/sass-basis-layout/src/css/layout/container';
```

## Using sticky header

The header fixed to top and the contents is under the header.

### HTML
```
<div class="l-container">
  <header class="l-header" data-l-header-type="sticky"></header>
  <div class="l-contents"></div>
  <footer class="l-footer"></footer>
</div>
```

### JavaScript
```
import BasisStickyHeader from 'node_modules/sass-basis-layout/src/js/sticky-header.js';

document.addEventListener(
  'DOMContentLoaded',
  () => {
    new BasisStickyHeader({
      container: '.l-container',
      header   : '.l-header',
      contents : '.l-contents'
    });
  },
  false
);
```

## Using overlay header

The header fixed to top and overlay the contents.

### HTML
```
<div class="_l-container">
  <header class="_l-header" data-l-header-type="overlay"></header>
  <div class="_l-contents"></div>
  <footer class="_l-footer"></footer>
</div>
```

### JavaScript
```
import BasisFixedHeader from 'node_modules/sass-basis-layout/src/js/fixed-header.js';

document.addEventListener(
  'DOMContentLoaded',
  () => {
    new BasisFixedHeader({
      container: '.l-container',
      header   : '.l-header'
    });
  },
  false
);
```

## Using sticky footer

The footer fixed to bottom when the contents is smaller than the height of the window.

### HTML
```
<html data-sticky-footer="true">
  <div class="l-container">
    <header class="l-header"></header>
    <div class="l-contents"></div>
    <footer class="l-footer"></footer>
  </div>
</html>
```

## Using disable window scroll

Scroll the contents of the page instead of scrolling the window.

### HTML
```
<html data-window-scroll="false">
  <div class="l-container">
    <header class="l-header"></header>
    <div class="l-contents"></div>
    <footer class="l-footer"></footer>
  </div>
</html>
```

### JavaScript

When with using sticky or overlay header.

```
import BasisStickyHeader from 'node_modules/sass-basis-layout/src/js/sticky-header.js';

document.addEventListener(
  'DOMContentLoaded',
  () => {
    new BasisStickyHeader({
      container: '.l-container',
      header   : '.l-header',
      contents : '.l-contents'
    });
  },
  false
);

import BasisFixedHeader from 'node_modules/sass-basis-layout/src/js/fixed-header.js';

document.addEventListener(
  'DOMContentLoaded',
  () => {
    new BasisFixedHeader({
      container: '.l-container',
      header   : '.l-header'
    });
  },
  false
);
```

## Browser support
Modern Browser and IE10+

## License
MIT License
