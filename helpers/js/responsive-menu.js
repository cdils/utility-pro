( function( window, $, undefined ) {
	'use strict';

	$( '.menu-primary' ).before( '<button class="menu-toggle primary-menu-toggle" role="button" aria-pressed="false">menu</button>' ); // Add toggles to menus
	$( '.sub-menu' ).before( '<button class="menu-toggle menu-toggle-footer" role="button" aria-pressed="false"></button>' ); // Add toggles to sub menus

	// Show/hide the navigation
	$( '.menu-toggle, .sub-menu-toggle' ).on( 'click.utility-pro', function() {
		var $this = $( this );
		$this.attr( 'aria-pressed', function( index, value ) {
			return 'false' === value ? 'true' : 'false';
		});

		$this.toggleClass( 'menu-toggle-activated' );
		$this.next( '.menu-primary, .sub-menu' ).slideToggle( 'fast' );

	});

})( this, jQuery );