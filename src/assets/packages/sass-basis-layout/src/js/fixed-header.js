/**
 * IF "disable-window-scroll", to set the intended header width.
 */

'use strict';

export default class BasisFixedHeader {
  constructor(args = {}) {
    this.args = {};
    this.args.container = this.args.container || '.l-container';
    this.args.header = this.args.header || '.l-header';

    this.windowScroll = document.querySelector('html').getAttribute('data-window-scroll');
    this.header       = document.querySelector(this.args.header);
    this.container    = document.querySelector(this.args.container);

    if (! this.header || ! this.container) {
      return;
    }

    if (this._shouldSetHeaderWidth()) {
      this._setHeaderWidth();
      window.addEventListener('resize', () => this._setHeaderWidth(), false);
    }
  }

  _shouldSetHeaderWidth() {
    const position = this.header.style.position;
    return 'fixed' === position && 'false' === this.windowScroll;
  }

  _setHeaderWidth() {
    const body = document.querySelector('body');
    const scrollbarWidth = body.clientWidth - this.container.clientWidth;
    if (scrollbarWidth > 0) {
      this.header.style.width = `calc(100% - ${scrollbarWidth}px)`;
    }
  }
}
