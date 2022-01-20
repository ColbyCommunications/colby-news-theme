const setUpSiteHeader = () => {
  const headers = document.querySelectorAll('.site-header');
  if (!headers.length) return;

  const realHeader = (() => {
    for (const header of headers) {
      if (header.id === 'site-header') return header;
    }
  })();

  const rem = px => `${px / 16}rem`;

  const modals = new Map();

  const setUpModal = ({ menuId, openButtonClass, closeButtonId }) => {
    const { MicroModal } = window;
    const menu = document.querySelector(`#${menuId}`);
    const openButtons = document.querySelectorAll(`.${openButtonClass}`);
    const openButtonWrappers = document.querySelectorAll(`.${openButtonClass}-wrapper`);

    if (!MicroModal || !menu || !openButtons.length || !openButtonWrappers.length) return;

    const realHeaderOpenButton = realHeader && (() => {
      for (const button of openButtons) {
        if (realHeader.contains(button)) return button;
      }
    })();

    const closeButton = menu.querySelector(`#${closeButtonId}`);
    if (!closeButton) return;

    // set openButtonWrappers to trigger closeButton (when it's not disabled)
    openButtonWrappers.forEach(e => e.addEventListener('click', () => {
      if (!closeButton.disabled) closeButton.click();
    }));

    const focusTargetAncestor = menu.querySelector('.focus-target-ancestor');

    // to allow for limited control of this modal from outside of this function
    const modalInfo = {
      isOpen: false,
      openButtons,
      close: () => {} // placeholder; gets its real value below, at the end of this function
    };

    modals.set(menu.id, modalInfo);

    // for available options, see https://micromodal.now.sh/#configuration
    // note: the `onShow` and `onClose` methods run just when their respective fade-animations BEGIN,
    // so we'll also use `animationend` handlers later for other tasks
    const showModal = () => {
      window.MicroModal.show(menu.id, {
        onShow: () => {
          menu.scrollTo(0, 0);
          modalInfo.isOpen = true;
          openButtons.forEach(button => button.classList.add('selected'));
        },
        onClose: () => {
          modalInfo.isOpen = false;
          if (realHeader) realHeader.classList.remove('invisible');
          openButtons.forEach(button => button.classList.remove('selected'));
        },
        openClass: '!block', // !important TW class to override menu's `hidden` class */
        disableScroll: true,
        disableFocus: !!focusTargetAncestor, // so we can manage focus-on-open manually if desired (see below)
        awaitOpenAnimation: true,
        awaitCloseAnimation: true,
      });
    };

    // if applicable, find element to focus on when modal opens (we assume some stability of content within menu)
    const focusTarget = focusTargetAncestor && document.createTreeWalker(
      focusTargetAncestor,
      NodeFilter.SHOW_ELEMENT,
      {
        acceptNode: node => (node.tabIndex >= 0)
          ? NodeFilter.FILTER_ACCEPT
          : NodeFilter.FILTER_SKIP
      }
    ).nextNode();


    /**
     * MicroModal allows escape-key to close modal. We do want this behavior,
     * but A) we need to disable it during the fade-in animation,
     * and B) we need it to call our custom closing-function:
     */

    // A) this `keydown` handler will be in effect during fade-in animation
    const disableEscapeKey = event => {
      if (event.key === 'Escape') event.stopImmediatePropagation();
    };

    // B) this one will be in effect between when fade-in animation ends and when fade-out animation starts
    const closeOnEscape = event => {
      if (event.key === 'Escape') {
        closeButton.click();
        event.stopImmediatePropagation();
      }
    };
  
    // custom modal-open behavior
    openButtons.forEach(button => button.addEventListener('click', () => {
      // immediately close other modals and disable their openButtons
      modals.forEach(({ isOpen, close, openButtons: openers }, id) => {
        if (id !== menu.id) {
          if (isOpen) close();
          openers.forEach(button => {
            button.disabled = true;
            button.classList.remove('focus-visible'); /* help "focus-visible" polyfill in Firefox */
          });
        }
      });

      // prevent interrupting open-animation
      openButtons.forEach(button => {
        button.disabled = true;
        button.classList.remove('focus-visible'); /* help "focus-visible" polyfill in Firefox */
      });
      document.addEventListener('keydown', disableEscapeKey);
  
      /*
        When open-animation ends:
        1. enable the closing-mechanisms (closeButton and escape-key);
        2. set the main site-header to `invisible` (to avoid presence of duplicate markup/landmark-roles/ids);
        3. give focus to focusTarget
        4. enable opening-mechanisms for OTHER MODALS
      */
      menu.addEventListener('animationend', function openCleanup({ currentTarget, target }) {
        if (target !== currentTarget) return;
  
        menu.removeEventListener('animationend', openCleanup);
        document.removeEventListener('keydown', disableEscapeKey);
        document.addEventListener('keydown', closeOnEscape);
        closeButton.disabled = false;

        if (realHeader) realHeader.classList.add('invisible');

        if (focusTarget) focusTarget.focus();

        modals.forEach(({ openButtons: openers }, id) => {
          if (id !== menu.id) {
            openers.forEach(button => button.disabled = false);
          }
        });
      });
  
      // open the modal (there's a fade-in animation)
      showModal();
    }));
  
    // custom modal-close behavior
    closeButton.addEventListener('click', () => {
      // prevent interrupting close-animation
      closeButton.disabled = true;
  
      // when close-animation ends, we'll enable the open-buttons and give focus to the one in the "real" site-header
      menu.addEventListener('animationend', function closeCleanup({ currentTarget, target }) {
        if (target !== currentTarget) return;
  
        menu.removeEventListener('animationend', closeCleanup);
        document.removeEventListener('keydown', closeOnEscape);
        openButtons.forEach(button => {
          button.disabled = false;
          button.classList.remove('focus-visible'); /* help "focus-visible" polyfill in Firefox */
        });
  
        if (realHeaderOpenButton) realHeaderOpenButton.focus();
      });

      // close the modal (there's a fade-out animation)
      MicroModal.close(menu.id);
    });

    // so that the modal can be immediately closed from outside of this function;
    // need to also un-disable its openButtons at the right time
    modalInfo.close = () => {
      closeButton.disabled = true;
      document.removeEventListener('keydown', closeOnEscape);
      MicroModal.close(menu.id);
      menu.dispatchEvent(new Event('animationend')); // b/c  of `awaitCloseAnimation` MicroModal setting
    };
  };

  const setUpHeightTracker = () => {
    if (window.ResizeObserver) {
      new ResizeObserver(entries => {
        entries.forEach(entry => {
          if (entry.contentBoxSize) {
            // Firefox implements `contentBoxSize` as a single content rect, rather than an array
            const contentBoxSize = Array.isArray(entry.contentBoxSize) ? entry.contentBoxSize[0] : entry.contentBoxSize;
            document.documentElement.style.setProperty('--header-height', rem(contentBoxSize.blockSize));
          } else {
            document.documentElement.style.setProperty('--header-height', rem(entry.contentRect.height));
          }
        });
      }).observe(realHeader);
    } else {
      // Fallback to prevent erros if ResizeObserver is unsupported.
      // Realistically, setting this variable statically should suffice, anyway.
      document.documentElement.style.setProperty('--header-height', rem(realHeader.clientHeight));
    }
  };

  const setUpStickyEvents = () => {
    /*
      copy-pasted almost verbatim from https://github.com/ryanwalters/sticky-events/blob/master/sticky-events.js
      (not available via CDN, apparently)
    */

    const ClassName = {
      SENTINEL: 'sticky-events--sentinel',
      SENTINEL_TOP: 'sticky-events--sentinel-top',
      SENTINEL_BOTTOM: 'sticky-events--sentinel-bottom',
    };
    
    
    // StickyEvents class
    
    class StickyEvents {
      /**
       * Initialize a set of sticky elements with events
       *
       * @param {Element|Document} container
       * @param {boolean} enabled
       * @param {string} stickySelector
       */
    
      constructor({ container = document, enabled = true, stickySelector = '.sticky-events' } = {}) {
        this.container = container;
        this.observers = [];
        this.stickyElements = Array.from(this.container.querySelectorAll(stickySelector));
        this.stickySelector = stickySelector;
        this.state = new Map();
    
        if (enabled) {
          this.enableEvents();
        }
      }
    
    
      /**
       * Initialize the state for a sticky:
       * 1. Default isSticky to false
       * 2. Create and observe a header sentinel
       * 3. Create and observe a footer sentinel
       *
       * @param {HTMLElement|Node} sticky
       */
    
      setState(sticky) {
        if (this.state.get(sticky)) {
          return;
        }
    
        this.state.set(sticky, {
          isSticky: false,
          headerSentinel: this.addSentinel(sticky, ClassName.SENTINEL_TOP),
          footerSentinel: this.addSentinel(sticky, ClassName.SENTINEL_BOTTOM),
        });
      }
    
    
      /**
       * Initialize the intersection observers on `.sticky` elements within the specified container.
       * Container defaults to `document`.
       */
    
      enableEvents() {
        // if (window.self !== window.top) {
        //   console.warn('StickyEvents: There are issues with using IntersectionObservers in an iframe, canceling initialization. Please see https://github.com/w3c/IntersectionObserver/issues/183');
    
        //   return;
        // }
    
        // Create IntersectionObservers for header and footer sentinels
    
        this.observers = {
          header: this.createHeaderObserver(),
          footer: this.createFooterObserver(),
        };
    
        // Then, initialize the sticky's state
    
        this.stickyElements.forEach((sticky) => {
          this.setState(sticky);
        });
      }
    
    
      /**
       * Reset the DOM to it's pre-sticky state.
       * 1. (Optionally) Fire a sticky-unstuck event on all stickies to reset them to their original unstuck state
       * 2. Disconnect and remove IntersectionObservers
       * 3. Clear out the global state
       *
       * @param {boolean} resetStickies
       */
    
      disableEvents(resetStickies = true) {
        if (resetStickies) {
          this.stickyElements.forEach(sticky => this.fire(false, sticky));
        }
    
        Object.values(this.observers).forEach(observer => observer.disconnect());
    
        this.observers = null;
    
        this.state.clear();
      }
    
    
      /**
       * Add a list of stickies to the existing set
       *
       * @param {NodeList} stickies
       */
    
      addStickies(stickies) {
        this.stickyElements.push(...stickies);
        this.stickyElements.forEach(sticky => this.setState(sticky));
      }
    
    
      /**
       * Add a single sticky to the existing set
       *
       * @param {Node} sticky
       */
    
      addSticky(sticky) {
        this.stickyElements.push(sticky);
        this.setState(sticky);
      }
    
    
      /**
       * Create and observe a sentinel for given sticky. Type of sentinel is determined by className.
       *
       * @param {HTMLElement} sticky
       * @param {string} className
       * @returns {Element}
       */
    
      addSentinel(sticky, className) {
        const sentinel = document.createElement('div');
        const stickyParent = sticky.parentElement;
    
        // Apply styles to the sticky element
    
        sticky.style.cssText = `
          position: -webkit-sticky;
          position: sticky;
        `;
    
        // Apply default sentinel styles
    
        sentinel.classList.add(ClassName.SENTINEL, className);
    
        Object.assign(sentinel.style,{
          left: 0,
          position: 'absolute',
          right: 0,
          visibility: 'hidden',
        });
    
        switch (className) {
          case ClassName.SENTINEL_TOP: {
            stickyParent.insertBefore(sentinel, sticky);
    
            // Apply styles specific to the top sentinel
    
            Object.assign(
              sentinel.style,
              this.getSentinelPosition(sticky, sentinel, className),
              { position: 'relative' },
            );
    
            // Observe the sentinel
    
            this.observers.header.observe(sentinel);
    
            break;
          }
    
          case ClassName.SENTINEL_BOTTOM: {
            stickyParent.appendChild(sentinel);
    
            // Apply styles specific to the bottom sentinel
    
            Object.assign(sentinel.style, this.getSentinelPosition(sticky, sentinel, className));
    
            // Observe the sentinel
    
            this.observers.footer.observe(sentinel);
    
            break;
          }
        }
    
        return sentinel;
      }
    
    
      /**
       * Sets up an intersection observer to notify `document` when elements with the `ClassName.SENTINEL_TOP` become
       * visible/hidden at the top of the sticky container.
       *
       * @returns {IntersectionObserver}
       */
    
      createHeaderObserver() {
        return new IntersectionObserver(([record]) => {
          const { boundingClientRect, isIntersecting, rootBounds } = record;
          const stickyParent = record.target.parentElement;
          const stickyTarget = stickyParent.querySelector(this.stickySelector);
    
          stickyParent.style.position = 'relative';
    
          if (boundingClientRect.bottom < rootBounds.bottom && isIntersecting) {
            this.fire(false, stickyTarget, StickyEvents.POSITION_TOP);
          }
    
          else if (boundingClientRect.bottom <= rootBounds.top && !isIntersecting) {
            this.fire(true, stickyTarget, StickyEvents.POSITION_TOP);
          }
        }, Object.assign({
          threshold: 0,
        }, !(this.container instanceof HTMLDocument) && {
          root: this.container
        }));
      }
    
    
      /**
       * Sets up an intersection observer to notify `document` when elements with the `ClassName.SENTINEL_BOTTOM` become
       * visible/hidden at the bottom of the sticky container.
       *
       * @returns {IntersectionObserver}
       */
    
      createFooterObserver() {
        return new IntersectionObserver(([record]) => {
          const { boundingClientRect, isIntersecting, rootBounds } = record;
          const stickyTarget = record.target.parentElement.querySelector(this.stickySelector);
    
          if (boundingClientRect.top < rootBounds.top && boundingClientRect.bottom < rootBounds.bottom && !isIntersecting) {
            this.fire(false, stickyTarget, StickyEvents.POSITION_BOTTOM);
          }
    
          else if (boundingClientRect.bottom > rootBounds.top && this.isSticking(stickyTarget) && isIntersecting) {
            this.fire(true, stickyTarget, StickyEvents.POSITION_BOTTOM);
          }
        }, Object.assign({
          threshold: 1,
        }, !(this.container instanceof HTMLDocument) && {
          root: this.container
        }));
      }
    
    
      /**
       * Dispatch the following events:
       * - `sticky-change`
       * - `sticky-stuck` or `sticky-unstuck`
       *
       * @param {Boolean} isSticky
       * @param {Element} stickyTarget
       * @param {StickyEvents.POSITION_BOTTOM|StickyEvents.POSITION_TOP} position
       */
    
      fire(isSticky, stickyTarget, position) {
        const { isSticky: previouslySticky } = this.state.get(stickyTarget);
    
        // Don't fire any events if the new state is the same as the previous state
    
        if (previouslySticky === isSticky) {
          return;
        }
    
        // Fire some events if the state is changing
    
        stickyTarget.dispatchEvent(new CustomEvent(StickyEvents.CHANGE, { detail: { isSticky, position }, bubbles: true }));
        stickyTarget.dispatchEvent(new CustomEvent(isSticky ? StickyEvents.STUCK : StickyEvents.UNSTUCK, { detail: { isSticky, position }, bubbles: true }));
    
        // Update the sticky state
    
        this.state.set(stickyTarget, { isSticky });
      }
    
    
      /**
       * Determine the position of the sentinel
       *
       * @param {Element|Node} stickyElement
       * @param {Element|Node} sentinel
       * @param {String} className
       * @returns {Object}
       */
    
      getSentinelPosition(stickyElement, sentinel, className) {
        const stickyStyle = window.getComputedStyle(stickyElement);
        const parentStyle = window.getComputedStyle(stickyElement.parentElement);
    
        switch (className) {
          case ClassName.SENTINEL_TOP:
            return {
              top: `calc(${stickyStyle.getPropertyValue('top')} * -1)`,
              height: 1,
            };
    
          case ClassName.SENTINEL_BOTTOM:
            // eslint-disable-next-line no-case-declarations
            const parentPadding = parseInt(parentStyle.paddingTop);
    
            return {
              bottom: stickyStyle.top,
              height: `${stickyElement.getBoundingClientRect().height + parentPadding}px`,
            };
        }
      }
    
    
      /**
       * Determine if the sticky element is currently sticking in the browser
       *
       * @param {Element} stickyElement
       * @returns {boolean}
       */
    
      isSticking(stickyElement) {
        const topSentinel = stickyElement.previousElementSibling;
    
        const stickyOffset = stickyElement.getBoundingClientRect().top;
        const topSentinelOffset = topSentinel.getBoundingClientRect().top;
        const difference = Math.round(Math.abs(stickyOffset - topSentinelOffset));
    
        const topSentinelTopPosition = Math.abs(parseInt(window.getComputedStyle(topSentinel).getPropertyValue('top')));
    
        return difference !== topSentinelTopPosition;
      }
    }
    
    // Events
    
    StickyEvents.CHANGE = 'sticky-change';
    StickyEvents.STUCK = 'sticky-stuck';
    StickyEvents.UNSTUCK = 'sticky-unstuck';
    
    // Position
    
    StickyEvents.POSITION_BOTTOM = 'bottom';
    StickyEvents.POSITION_TOP = 'top';


    const stickyEvents = new StickyEvents({ stickySelector: '.site-header' });
    stickyEvents.stickyElements.forEach(sticky => {
      sticky.addEventListener(StickyEvents.CHANGE, event => {
        sticky.classList.toggle('stuck', event.detail.isSticky);
      });
    });
  };

  /*
    because sticky-position header can hide focused-elements, we want to make sure
    that any element that receives focus gets scrolled into visibility if it was
    behind the sticky-header (it's a keyboard-accessibility issue)
  */
  const setUpFocusUnblocker = () => {
    document.addEventListener('focus', () => {
      const el = document.activeElement;

      // if focused element is IN a sticky-position header (or is the body) then do nothing
      if (el === document.body || el.matches('.site-header *')) return;

      // determine whether focused element is behind the sticky-header
      const { top } = el.getBoundingClientRect();
      const headerHeight = parseInt(document.documentElement.style.getPropertyValue('--header-height')) * 16;
      const diff = top - headerHeight;

      // if it is, then scroll the element to the bottom of the viewport
      if (diff < 0) el.scrollIntoView(false);
    }, true);
  };

  setUpModal({
    menuId: 'main-menu',
    openButtonClass: 'open-menu',
    closeButtonId: 'close-menu'
  });

  setUpModal({
    menuId: 'site-search',
    openButtonClass: 'open-search',
    closeButtonId: 'close-search'
  });

  setUpHeightTracker();

  setUpStickyEvents();

  setUpFocusUnblocker();
};

// if live site (i.e., not Storybook), run function
if (!window.STORYBOOK_ENV) setUpSiteHeader();

export default setUpSiteHeader;
