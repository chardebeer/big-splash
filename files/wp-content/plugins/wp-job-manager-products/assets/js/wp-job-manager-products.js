jQuery( document ).ready( function( $ ) {

	if ( typeof $.fn.select2 == 'undefined' ) {
		return;
	}

	$( '.fieldset-products #products, #_products' ).select2({
		width: '100%',
		allowClear: true,
		maximumSelectionLength: wpjmp.chosen_max_selected_options,
	});
});