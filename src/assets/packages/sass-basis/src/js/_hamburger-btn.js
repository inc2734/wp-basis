'use strict';

import forEachHtmlNodes from '@inc2734/for-each-html-nodes';
import addCustomEvent from '@inc2734/add-custom-event';
import BasisDrawer from './_drawer.js';
import { open, close } from './_helper';

export default class BasisHamburgerBtn {
  constructor(args = {}) {
    this.args = args;
    this.args.btn = this.args.btn || '.c-hamburger-btn';

    forEachHtmlNodes(
      document.querySelectorAll(this.args.btn),
      (element) => {
        element.addEventListener('click', (event) => this._click(event), false);

        const drawer = document.getElementById(element.getAttribute('aria-controls'));
        if (null !== drawer) {
          element.addEventListener('openHamburgerBtn', () => BasisDrawer.open(drawer), false);
          element.addEventListener('closeHamburgerBtn', () => BasisDrawer.close(drawer), false);
          drawer.addEventListener('closeDrawer', () => BasisHamburgerBtn.close(element), false);
          drawer.addEventListener('openDrawer', () => BasisHamburgerBtn.open(element), false);
        }
      }
    );
  }

  static open(hamburgerBtn) {
    if ('true' === hamburgerBtn.getAttribute('aria-expanded')) {
      return;
    }

    open(hamburgerBtn);
  }

  static close(hamburgerBtn) {
    if ('false' === hamburgerBtn.getAttribute('aria-expanded')) {
      return;
    }

    close(hamburgerBtn);
  }

  _click(event) {
    event.preventDefault();
    event.stopPropagation();

    const hamburgerBtn = event.currentTarget;

    if ('false' === hamburgerBtn.getAttribute('aria-expanded')) {
      addCustomEvent(hamburgerBtn, 'openHamburgerBtn');
    } else {
      addCustomEvent(hamburgerBtn, 'closeHamburgerBtn');
    }
  }
}
