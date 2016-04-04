/* global jQuery:false, utilityMenuPrimaryL10n:false, utilityMenuFooterL10n:false */

jQuery( function( $ ) {
    'use strict';

    $( '.nav-primary' ).gamajoResponsiveAccessibleMenu(
        {
            l10n: utilityMenuPrimaryL10n
        }
    );

    $( '.nav-footer' ).gamajoResponsiveAccessibleMenu(
        {
            l10n: utilityMenuFooterL10n,
            navSelector: '.nav-footer',
            mainMenuButtonClass: 'footer-menu-toggle'
        }
    );
} );
