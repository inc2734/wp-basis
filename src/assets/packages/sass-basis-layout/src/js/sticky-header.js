/**
 * This is for the sticky header.
 */

'use strict';

import addCustomEvent from '@inc2734/add-custom-event';

export default class BasisStickyHeader {
  constructor(args = {}) {
    this.args = {};
    this.args.container = this.args.container || '.l-container';
    this.args.header = this.args.header || '.l-header';
    this.args.contents = this.args.contents || '.l-contents';

    this.windowScroll = document.querySelector('html').getAttribute('data-window-scroll');
    this.header       = document.querySelector(this.args.header);
    this.contents     = document.querySelector(this.args.contents);
    this.container    = document.querySelector(this.args.container);

    if (! this.header || ! this.contents || ! this.container) {
      return;
    }

    this._setScroll();
    this._setSticky();

    const target = this._getScrollTarget();

    target.addEventListener(
      'scroll',
      () => {
        this._setScroll();
        this._setSticky();
      },
      false
    );

    target.addEventListener(
      'resize',
      () => {
        this._setScroll();
        this._setSticky();
      },
      false
    );
  }

  _setScroll() {
    const scroll   = this._getScrollTop();
    const html     = document.querySelector('html');
    const scrolled = scroll > 0 ? 'true' : 'false';

    html.setAttribute('data-scrolled', scrolled);
  }

  _setSticky() {
    if ('sticky' !== this.header.getAttribute('data-l-header-type')) {
      return;
    }

    const headerHeight = this.header.offsetHeight;
    this.contents.style.marginTop = `${headerHeight}px`;

    addCustomEvent(document, 'afterSetStickyHeader');
  }

  _getScrollTarget() {
    return 'false' == this.windowScroll ? this.container : window;
  }

  _getScrollTop() {
    const target = this._getScrollTarget();
    return window === target ? document.documentElement.scrollTop || document.body.scrollTop : target.scrollTop;
  }
}
