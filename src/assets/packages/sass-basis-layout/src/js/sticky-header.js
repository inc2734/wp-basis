/**
 * This is for the sticky header.
 */

'use strict';

import $ from 'jquery';

export default class BasisStickyHeader {
  constructor(args = {}) {
    this.args = $.extend({
      container: '.l-container',
      header   : '.l-header',
      contents : '.l-contents'
    }, args);

    this.windowScroll = $('html').attr('data-window-scroll');

    this.setScroll();
    this.setSticky();
    this.setListener();
  }

  setListener() {
    const target = this.getScrollTarget();

    target.on('scroll resize', (event) => {
      this.setScroll();
      this.setSticky();
    });
  }

  setScroll() {
    const scroll = this.getScrollTop();

    if (scroll > 0) {
      $('html').attr('data-scrolled', 'true');
    } else {
      $('html').attr('data-scrolled', 'false');
    }
  }

  setSticky() {
    if ('sticky' !== $(this.args.header).attr('data-l-header-type')) {
      return;
    }
    const headerHeight = $(this.args.header).outerHeight();
    $(this.args.contents).css('marginTop', `${headerHeight}px`);
  }

  getScrollTarget() {
    if ('false' == this.windowScroll) {
      return $(this.args.container);
    } else {
      return $(window);
    }
  }

  getScrollTop() {
    return this.getScrollTarget().scrollTop();
  }
}
