( function ( $ ) {

	// Menu Behavior
	$( '.menu-toggle button' )
		.on( 'click', function ( e ) {
			e.preventDefault();

			$( '.main-navigation' ).slideToggle();

		} );

	$( '.main-navigation .menu-item-has-children' )
		.on( 'click', function ( e ) {
		e.preventDefault();

		$( this ).find( '.sub-menu' ).slideToggle();

	} )

} )( jQuery );