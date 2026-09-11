/**
 * Strips the native hover tooltip off the header logo.
 *
 * The logo is Elementor Theme Builder content (shared by every page - see
 * CLAUDE.md on why this theme never edits _elementor_data directly), and its
 * image widget has a title attribute set ("logo pribadi") that the browser
 * shows as a tooltip on hover. DOM removal here, rather than a database
 * edit, for the same reason language-switch.js and mobile-nav.js already
 * work this way.
 */
( function () {
	'use strict';

	function init() {
		var header = document.getElementById( 'site-header' );

		if ( ! header ) {
			return;
		}

		header.querySelectorAll( '.elementor-widget-image img[title]' ).forEach( function ( img ) {
			img.removeAttribute( 'title' );
		} );
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
