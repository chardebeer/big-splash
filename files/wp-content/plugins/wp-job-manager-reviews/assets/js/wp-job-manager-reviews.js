jQuery( document ).ready( function( $ ) {

	$( '.choose-rating' ).on( 'click', '.star', function( event ) {

		// Remove all current stars
		$( this ).nextAll( '.star' ).removeClass( 'active' );
		$( this ).prevAll( '.star' ).removeClass( 'active' );

		$( this ).toggleClass( 'active' );
		
		// Set rating at the hidden input
		$( this ).parent().find( '.wpjmr-rating-input' ).attr( 'value', $( this ).attr( 'data-star-rating' ) );
	});

	// Display inital/default star.
	$( '.wpjmr-rating-input' ).each( function( index ) {
		$( this ).parent( '.stars' ).find( 'span[data-star-rating="' + $( this ).val() + '"]' ).trigger( 'click' );
	} );

});