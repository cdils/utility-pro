

// The small bit below starts the library. Pass in whatever configurations you need.
// The defaults are shown, commented out. The l10n is a special option - instead of passing in the individual strings,
// just give the name of the localized strings object you created when enqueueing your scripts.

jQuery( document ).gamajoResponsiveAccessibleMenu( {
  hoverClass: 'menu-item-hover',
  hoverDelay: 250,
  navSelector: '.nav-primary',
  menuItemClass: 'menu-item',
  parentItemClass: 'menu-item-has-children',
  subMenuClass: 'sub-menu',
  mainMenuButtonClass: 'menu-toggle',
  subMenuButtonClass: 'sub-menu-toggle',
  screenReaderClass: 'screen-reader-text',
  slideSpeed: 'fast',
  superfishSelector: '.js-superfish',
  superfishArgs: {
      'delay': 100,
      'dropShadows': false,
      'animation': {
          'opacity': 'show',
          'height': 'show'
      }
  },
 l10n: utilityMenuPrimaryL10n
} );
