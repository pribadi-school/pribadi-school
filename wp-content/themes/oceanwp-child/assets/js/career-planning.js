/**
 * Career Planning page (page-career-planning.php): the pill buttons swap the
 * write-up and the photo collage.
 *
 * Progressive enhancement: the pills ship with `hidden`, and every topic
 * after the first ships hidden too, so without JS the page simply shows the
 * first topic. This reveals the pills and does the swap.
 */
( function () {
	'use strict';

	var root = document.querySelector( '[data-cp]' );
	var bar = root && root.querySelector( '[data-cp-pills]' );

	if ( ! bar ) {
		return;
	}

	var pills = Array.prototype.slice.call( bar.querySelectorAll( '[data-cp-pill]' ) );
	var texts = Array.prototype.slice.call( root.querySelectorAll( '[data-cp-text]' ) );
	var photos = Array.prototype.slice.call( root.querySelectorAll( '[data-cp-photos]' ) );

	function show( key ) {
		pills.forEach( function ( pill ) {
			var on = pill.getAttribute( 'data-cp-pill' ) === key;

			pill.classList.toggle( 'is-active', on );
			pill.setAttribute( 'aria-pressed', on ? 'true' : 'false' );
		} );

		texts.forEach( function ( text ) {
			text.hidden = text.getAttribute( 'data-cp-text' ) !== key;
		} );

		photos.forEach( function ( set ) {
			set.hidden = set.getAttribute( 'data-cp-photos' ) !== key;
		} );
	}

	bar.hidden = false;

	bar.addEventListener( 'click', function ( event ) {
		var pill = event.target.closest( '[data-cp-pill]' );

		if ( pill ) {
			show( pill.getAttribute( 'data-cp-pill' ) );
		}
	} );
}() );
