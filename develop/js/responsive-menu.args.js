/* global jQuery:false, utilityMenuPrimaryL10n:false, utilityMenuFooterL10n:false */

jQuery( function( $ ) {
    'use strict';

    $( '.nav-primary' ).gamajoResponsiveAccessibleMenu(
        {
            l10n: utilityProMenuPrimaryL10n
        }
    );

    $( '.nav-footer' ).gamajoResponsiveAccessibleMenu(
        {
            l10n: utilityProMenuFooterL10n,
            navSelector: '.nav-footer',
            mainMenuButtonClass: 'footer-menu-toggle'
        }
    );
} );
