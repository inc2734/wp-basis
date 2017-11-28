/**
 * IF "disable-window-scroll", to set the intended header width.
 */

'use strict';

import $ from 'jquery';

export default class BasisFixedHeader {
  constructor(args = {}) {
    this.args = $.extend({
      container: '.l-container',
      header   : '.l-header'
    }, args);

    this.windowScroll = $('html').attr('data-window-scroll');

    if (this.shouldSetHeaderWidth()) {
      this.setHeaderWidth();

      $(window).on('resize', (event) => {
        this.setHeaderWidth();
      });
    }
  }

  shouldSetHeaderWidth() {
    const position = $(this.args.header).css('position');
    if ('fixed' === position && 'false' == this.windowScroll) {
      return true;
    }
    return false;
  }

  setHeaderWidth() {
    const scrollbarWidth = $('body').innerWidth() - $(this.args.container)[0].clientWidth;
    if (scrollbarWidth > 0) {
      $(this.args.header).width('calc(100% - ' + scrollbarWidth + 'px)');
    }
  }
}
