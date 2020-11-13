'use strict';

import forEachHtmlNodes from '@inc2734/for-each-html-nodes';
import { show, hide } from './_helper';

export default class BasisPageEffect {
  constructor(args = {}) {
    this.args = args;
    this.args.pageEffect = this.args.pageEffect || '.c-page-effect';
    this.args.duration = this.args.duration || 0 === this.args.duration ? this.args.duration : 200;

    const container      = document.querySelector(this.args.pageEffect);
    const pageOutObjects = document.querySelectorAll('[data-page-effect-link="true"], a[href]:not([target="_blank"]):not([href^="#"]):not([href*="javascript"]):not([href*=".jpg"]):not([href*=".jpeg"]):not([href*=".gif"]):not([href*=".png"]):not([href*=".mov"]):not([href*=".swf"]):not([href*=".mp4"]):not([href*=".flv"]):not([href*=".avi"]):not([href*=".mp3"]):not([href*=".pdf"]):not([href*=".zip"]):not([href^="mailto:"]):not([data-page-effect-link="false"])');

    if (! container) {
      return;
    }

    const fadeInPage = () => {
      hide(container);
      container.setAttribute('data-page-effect', 'fadein');
    }

    const fadeOutPage = () => {
      show(container);
      container.setAttribute('data-page-effect', 'fadeout');
    }

    const moveLocation = (url) => {
      setTimeout(() => window.location.href = url, this.args['duration']);
    }

    window.addEventListener('load', () => fadeInPage(), false);
    window.addEventListener('pageshow', () => fadeInPage(), false);

    forEachHtmlNodes(
      pageOutObjects,
      (link) => {
        link.addEventListener(
          'click',
          (event) => {
            if (event.shiftKey || event.ctrlKey || event.metaKey) {
              return;
            }

            if (link.hash) {
              const _location = window.location.pathname + window.location.search;
              const _link = link.pathname + link.search;
              if (_location === _link) {
                return;
              }
            }

            event.preventDefault();
            fadeOutPage();
            moveLocation(link.getAttribute('href'));
          },
          false
        );
      }
    );
  }
}
