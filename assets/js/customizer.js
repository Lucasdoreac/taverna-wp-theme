/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 */
( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Custom colors.
	wp.customize( 'taverna_primary_color', function( value ) {
		value.bind( function( to ) {
			document.documentElement.style.setProperty('--taverna-primary', to );
		} );
	} );

	wp.customize( 'taverna_secondary_color', function( value ) {
		value.bind( function( to ) {
			document.documentElement.style.setProperty('--taverna-secondary', to );
		} );
	} );

	wp.customize( 'taverna_accent_color', function( value ) {
		value.bind( function( to ) {
			document.documentElement.style.setProperty('--taverna-accent', to );
		} );
	} );

} )( jQuery );